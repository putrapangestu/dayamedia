<?php

namespace App\Http\Controllers;

use App\Helpers\Transaction\TransactionHelper;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminIndividualBookController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user.affiliateLevel', 'individualBookPackage'])
            ->whereNotNull('individual_book_package_id')
            // ->where('individual_book_status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.pages.individual-books.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        if (!$transaction->individual_book_package_id) {
            abort(404);
        }

        $transaction->load(['user', 'individualBookPackage']);
        
        return view('admin.pages.individual-books.show', compact('transaction'));
    }

    public function confirm(Transaction $transaction)
    {
        DB::transaction(function () use ($transaction) {
            if ($transaction->status === 'paid' && $transaction->individual_book_status === 'confirmed') {
                return;
            }

            $transaction->update([
                'status' => 'paid',
                'individual_book_status' => 'confirmed',
                'individual_book_confirmed_at' => now(),
            ]);

            $buyer = $transaction->user;
            if ($buyer?->use_referral_code) {
                $affiliator = User::with('affiliateLevel')
                    ->whereHas('affiliateLevel')
                    ->where('referral_code', $buyer->use_referral_code)
                    ->first();

                if ($affiliator) {
                    TransactionHelper::calculateCommissionAffiliate($affiliator, $transaction);
                }
            }
        });

        return redirect()->route('admin.individual-books.index')->with('success', 'Transaksi dikonfirmasi');
    }

    public function reject(Request $request, Transaction $transaction)
    {
        $request->validate([
            'rejected_reason' => 'required|string',
        ]);

        $transaction->update([
            'individual_book_status' => 'rejected',
            'individual_book_rejected_at' => now(),
            'individual_book_rejected_reason' => $request->rejected_reason,
        ]);

        return redirect()->route('admin.individual-books.index')->with('success', 'Transaksi ditolak');
    }
}
