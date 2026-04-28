<?php

namespace App\Http\Controllers;

use App\Helpers\Transaction\TransactionHelper;
use App\Models\IndividualBookPackage;
use App\Models\Promo;
use App\Models\PromoHistory;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndividualBookPackageController extends Controller
{
    public function index()
    {
        $packages = IndividualBookPackage::with(['benefits' => function ($q) {
            $q->orderBy('sort_order');
        }])->where('status', 'active')->get();

        return view('landing.pages.individual-books.packages', compact('packages'));
    }

    public function purchase(IndividualBookPackage $package)
    {
        $additionalAuthorPrice = (int) getSetting('individual_additional_author_price', 0);

        return view('landing.pages.individual-books.purchase', compact('package', 'additionalAuthorPrice'));
    }

    public function storePurchase(Request $request, IndividualBookPackage $package)
    {
        $request->validate([
            'additional_authors_count' => 'nullable|integer|min:0',
            'promo_code' => 'nullable|string|max:50',
        ]);

        $additionalAuthorPrice = (int) getSetting('individual_additional_author_price', 0);
        $extraAuthors = max(0, (int) $request->input('additional_authors_count', 0));
        $chargeableExtras = $extraAuthors;
        $subtotal = (int) $package->price + ($chargeableExtras * $additionalAuthorPrice);
        $adminFee = (int) getAdminFeeTransaction();

        $promoCode = trim((string) $request->input('promo_code', ''));
        $promo = null;
        $discountAmount = 0;
        if ($promoCode !== '') {
            $promo = Promo::where('code', $promoCode)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->where('quantity', '>', 0)
                ->first();

            if (! $promo) {
                return back()->withInput()->with('error', 'Kode promo tidak valid atau telah kadaluarsa');
            }

            $usedCount = PromoHistory::where('promo_id', $promo->id)
                ->where('user_id', auth()->id())
                ->count();
            if ($usedCount > 0) {
                return back()->withInput()->with('error', 'Anda sudah menggunakan kode promo ini sebelumnya');
            }

            $boundBookIds = $promo->books()->pluck('books.id')->all();
            if (! empty($boundBookIds)) {
                return back()->withInput()->with('error', 'Promo ini tidak bisa digunakan untuk pembelian paket buku individu');
            }

            $discountAmount = (int) round(($subtotal * $promo->percentage) / 100);
        }

        $totalPrice = max(($subtotal + $adminFee) - $discountAmount, 0);

        $transaction = DB::transaction(function () use ($package, $extraAuthors, $totalPrice, $adminFee, $promo, $discountAmount) {
            $trx = Transaction::create([
                'user_id' => auth()->id(),
                'total_price' => $totalPrice,
                'status' => 'pending',
                'payment_method' => 'bank_transfer',
                'transaction_code' => TransactionHelper::generateTransactionCode('IND'),
                'admin_fee' => $adminFee,
                'promo_code' => $promo ? $promo->code : null,
                'discount_amount' => $discountAmount,
                'expired_at' => now()->addHours(getTransactionExpiredTime()),
                'individual_book_package_id' => $package->id,
                'additional_authors_count' => $extraAuthors,
                'individual_book_status' => 'pending',
            ]);

            TransactionDetail::create([
                'transaction_id' => $trx->id,
                'price_discount' => $discountAmount,
                'price_book' => $totalPrice,
                'quantity' => 1,
            ]);

            if ($promo) {
                PromoHistory::create([
                    'promo_id' => $promo->id,
                    'user_id' => auth()->id(),
                    'transaction_id' => $trx->id,
                    'discount_amount' => $discountAmount,
                ]);
                $promo->decrement('quantity');
            }

            return $trx;
        });

        return redirect()->route('checkout.success', $transaction->transaction_code)->with('success', 'Pesanan paket buku individu telah dibuat');
    }
}
