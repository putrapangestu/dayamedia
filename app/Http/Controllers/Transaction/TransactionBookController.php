<?php

namespace App\Http\Controllers\Transaction;

use App\Helpers\Transaction\TransactionHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\CreateBookTransactionRequest;
use App\Http\Requests\Transaction\VerificationTransaction;
use App\Models\Book;
use App\Models\BookHistory;
use App\Models\Cart;
use App\Models\Module;
use App\Models\Promo;
use App\Models\PromoHistory;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TransactionBookController extends Controller
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactions = Transaction::whereHas('details', function ($query) {
            $query->where('book_id', '!=', null);
        })->with(['user', 'details.book']);

        // Filter by transaction code
        if ($request->filled('transaction_code')) {
            $transactions->where('transaction_code', 'like', '%'.$request->transaction_code.'%');
        }

        // Filter by user name
        if ($request->filled('user_name')) {
            $transactions->whereHas('user', function ($query) use ($request) {
                $query->where('full_name', 'like', '%'.$request->user_name.'%');
            });
        }

        // Filter by status
        if ($request->status == 'waiting') {
            $transactions->where('status', 'pending')->whereNotNull('payment_proof');
        } elseif ($request->filled('status')) {
            $transactions->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $transactions->whereDate('created_at', $request->date);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $transactions->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $transactions->whereDate('created_at', '<=', $request->end_date);
        }

        $transactions = $transactions->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.pages.order.book-order', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::with(['user', 'details.book', 'details.module.book'])->findOrFail($id);

        return view('admin.pages.order.book-order-show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VerificationTransaction $request, string $id)
    {

        $transaction = Transaction::with('details', 'user')->findOrFail($id);

        DB::beginTransaction();
        try {
            $transaction->update($request->validated());

            // logic commission to royalti and affiliator
            if ($request->status == 'paid') {
                $commissionPercent = config('app.commission_percent');

                // summary balance royalti
                $promo = null;
                if ($transaction->promo_code) {
                    $promo = Promo::where('code', $transaction->promo_code)->first();
                }

                foreach ($transaction->details as $detail) {
                    $priceDiscount = $promo ? $detail->price_book * $detail->quantity * $promo?->percentage / 100 : 0;
                    $commission = (($detail->price_book * $detail->quantity) - $priceDiscount) * $commissionPercent / 100;

                    $books = Book::where('id', $detail->book_id)->with('authors', 'modules')->first();
                    if ($books) {
                        TransactionHelper::calculateCommissionRoyalti($commission, $books, $transaction);

                        // create book history
                        BookHistory::create([
                            'book_id' => $detail->book_id,
                            'user_id' => $transaction->user_id,
                            'expired_at' => null,
                        ]);
                    }
                }

                // summary balance affiliator
                if ($transaction->user->use_referral_code) {
                    $affiliator = User::with('affiliateLevel')->whereHas('affiliateLevel')->where('referral_code', $transaction->user->use_referral_code)->first();
                    if ($affiliator) {
                        TransactionHelper::calculateCommissionAffiliate($affiliator, $transaction);
                    }
                }
            }

            DB::commit();
            DB::afterCommit(function () use ($transaction, $request) {
                $number = $transaction->user->phone_number;
                $email = $transaction->user->email;
                if ($request->status === 'paid') {
                    $msg = "Pembayaran untuk transaksi {$transaction->transaction_code} telah diverifikasi. Terima kasih.";
                    try {
                        whatsapp_send($number, $msg, 2);
                    } catch (\Exception $e) {
                        Log::error('WhatsApp send failed', [
                            'to' => $number,
                            'message' => $msg,
                            'error' => $e->getMessage(),
                        ]);
                    }
                    try {
                        if ($email) {
                            Mail::raw($msg, function ($m) use ($email) {
                                $m->to($email)->subject('Pembayaran Diverifikasi');
                            });
                        }
                    } catch (\Exception $e) {
                        Log::error('Email send failed', [
                            'to' => $email,
                            'subject' => 'Pembayaran Diverifikasi',
                            'content' => $msg,
                            'error' => $e->getMessage(),
                        ]);
                    }
                } elseif ($request->status === 'rejected') {
                    $msg = "Pembayaran untuk transaksi {$transaction->transaction_code} ditolak. Mohon upload ulang bukti pembayaran.";
                    try {
                        whatsapp_send($number, $msg, 2);
                    } catch (\Exception $e) {
                        Log::error('WhatsApp send failed', [
                            'to' => $number,
                            'message' => $msg,
                            'error' => $e->getMessage(),
                        ]);
                    }
                    try {
                        if ($email) {
                            Mail::raw($msg, function ($m) use ($email) {
                                $m->to($email)->subject('Pembayaran Ditolak');
                            });
                        }
                    } catch (\Exception $e) {
                        Log::error('Email send failed', [
                            'to' => $email,
                            'subject' => 'Pembayaran Ditolak',
                            'content' => $msg,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            });

            return redirect()->route('admin.book-order.index')->with('success', 'Transaksi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function storeApiBook(CreateBookTransactionRequest $request)
    {
        $book = $request->validated();

        DB::beginTransaction();
        try {
            if ($request->hasFile('payment_proof')) {
                $book['payment_proof'] = $this->upload('transaction/payment_proof', $request->file('payment_proof'));
            }

            $details = collect($book['transaction_details'] ?? []);
            $moduleIds = $details->pluck('module_id')->filter()->unique()->values();
            if ($moduleIds->isNotEmpty()) {
                $availableCount = Module::availableForOrder()
                    ->whereIn('id', $moduleIds)
                    ->lockForUpdate()
                    ->count();

                if ($availableCount !== $moduleIds->count()) {
                    DB::rollBack();

                    return response()->json([
                        'message' => 'BAB sudah dibeli atau sedang menunggu pembayaran member lain.',
                    ], 422);
                }
            }

            $subtotal = $details->sum(function ($detail) {
                return ((int) ($detail['price_book'] ?? 0)) * ((int) ($detail['quantity'] ?? 0));
            });
            $adminFee = (int) getAdminFeeTransaction();

            $promo = null;
            $discountAmount = 0;
            $promoCode = isset($book['promo_code']) ? trim((string) $book['promo_code']) : null;
            if ($promoCode !== null && $promoCode !== '') {
                $promo = Promo::where('code', $promoCode)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->where('quantity', '>', 0)
                    ->first();

                if (! $promo) {
                    DB::rollBack();

                    return response()->json(['message' => 'Kode promo tidak valid atau telah kadaluarsa'], 422);
                }

                $usedCount = PromoHistory::where('promo_id', $promo->id)
                    ->where('user_id', auth()->id())
                    ->count();
                if ($usedCount > 0) {
                    DB::rollBack();

                    return response()->json(['message' => 'Anda sudah menggunakan kode promo ini sebelumnya'], 422);
                }

                $boundBookIds = $promo->books()->pluck('books.id')->all();
                if (! empty($boundBookIds)) {
                    $bookIds = $details->pluck('book_id')->filter()->unique()->values()->all();
                    $moduleIds = $details->pluck('module_id')->filter()->unique()->values()->all();
                    if (! empty($moduleIds)) {
                        $moduleBookIds = Module::whereIn('id', $moduleIds)
                            ->whereHas('book', function ($query) {
                                $query->where('status', Book::STATUS_PUBLISHED);
                            })
                            ->pluck('book_id')
                            ->filter()
                            ->unique()
                            ->values()
                            ->all();
                        $bookIds = array_values(array_unique(array_merge($bookIds, $moduleBookIds)));
                    }

                    $eligibleBoundBookIds = $promo->books()
                        ->where('books.status', Book::STATUS_PUBLISHED)
                        ->pluck('books.id')
                        ->all();
                    $hasBoundBookInCart = collect($bookIds)->intersect($eligibleBoundBookIds)->isNotEmpty();
                    if (! $hasBoundBookInCart) {
                        DB::rollBack();

                        return response()->json(['message' => 'Promo ini hanya bisa digunakan untuk buku yang sudah publish.'], 422);
                    }
                }

                $discountAmount = (int) round(($subtotal * $promo->percentage) / 100);
            }

            $totalPrice = max(($subtotal + $adminFee) - $discountAmount, 0);
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'total_price' => $totalPrice,
                'status' => 'pending',
                'payment_method' => $book['payment_method'],
                'transaction_code' => date('YmdHis'),
                'payment_proof' => $book['payment_proof'] ?? null,
                'promo_code' => $promo ? $promo->code : null,
                'discount_amount' => $discountAmount,
                'admin_fee' => $adminFee,
                'expired_at' => now()->addHours((int) Setting::get('expired_time', 24)),
            ]);

            // Apply promo code if exists
            if ($promo) {
                PromoHistory::create([
                    'promo_id' => $promo->id,
                    'user_id' => auth()->id(),
                    'transaction_id' => $transaction->id,
                    'discount_amount' => $discountAmount,
                ]);
                $promo->decrement('quantity');
            }
            foreach (($book['transaction_details'] ?? []) as $detail) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'book_id' => $detail['book_id'] ?? null,
                    'module_id' => $detail['module_id'] ?? null,
                    'quantity' => $detail['quantity'],
                    'price_book' => $detail['price_book'],
                    'price_discount' => $detail['price_discount'],
                    'type' => $detail['type'],
                ]);
            }

            $bookIds = collect($book['transaction_details'])->pluck('book_id');
            Cart::where('user_id', auth()->id())->whereIn('book_id', $bookIds)->delete();

            session()->forget(['checkout_items', 'checkout_total']);

            DB::commit();

            return response()->json(['message' => 'Transaksi buku berhasil dibuat', 'data' => $transaction], 201);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
