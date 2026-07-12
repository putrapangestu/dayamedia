<?php

namespace App\Http\Controllers;

use App\Helpers\Transaction\TransactionHelper;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminIndividualBookController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with(['user.affiliateLevel', 'individualBookPackage'])
            ->whereNotNull('individual_book_package_id');

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

        // Filter by individual book status
        if ($request->status == 'waiting') {
            $transactions->where('individual_book_status', 'pending')->whereNotNull('payment_proof');
        } elseif ($request->filled('status')) {
            $transactions->where('individual_book_status', $request->status);
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
                'expired_at' => null,
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
