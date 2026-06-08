<?php

namespace App\Helpers\Transaction;

use App\Models\AffiliateLevel;
use App\Models\Book;
use App\Models\CommissionHistory;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransactionHelper
{
    /**
     * Generate a unique transaction code.
     */
    public static function generateTransactionCode($prefix = 'TRX')
    {
        $datePart = date('Ymd');
        $randomPart = strtoupper(substr(uniqid(), -6));

        return $prefix.'-'.$datePart.'-'.$randomPart;
    }

    /**
     * calculate commission for affiliator and percentage.
     */
    public static function calculateCommissionAffiliate(User $affiliator, Transaction $transaction)
    {
        if (CommissionHistory::where('user_id', $affiliator->id)
            ->where('transaction_id', $transaction->id)
            ->where('type', 'affiliator')
            ->exists()) {
            return;
        }

        $baseCommission = 0;

        if ($transaction->individual_book_package_id) {
            // Jika pembelian paket buku individu, komisi afiliasi diambil dari 50% harga
            $baseCommission = ($transaction->total_price - $transaction->admin_fee) * 0.5;
        } else {
            // Jika pembelian buku/modul, cek masing-masing item apakah buku individu
            $subtotal = ($transaction->total_price - $transaction->admin_fee) + $transaction->discount_amount;
            $discountRate = $subtotal > 0 ? ($transaction->discount_amount / $subtotal) : 0;

            foreach ($transaction->details as $detail) {
                $itemPrice = $detail->price_book * $detail->quantity;
                $itemNetPrice = $itemPrice * (1 - $discountRate);

                $isIndividual = false;
                if ($detail->book && $detail->book->is_individual) {
                    $isIndividual = true;
                } elseif ($detail->module && $detail->module->book && $detail->module->book->is_individual) {
                    $isIndividual = true;
                }

                if ($isIndividual) {
                    $baseCommission += $itemNetPrice * 0.5; // 50% untuk buku individu
                } else {
                    $baseCommission += $itemNetPrice;
                }
            }

            // Fallback jika details kosong (misal data lama)
            if ($baseCommission == 0 && $transaction->total_price > 0) {
                $baseCommission = $transaction->total_price - $transaction->admin_fee;
            }
        }

        $affiliateLevel = $affiliator->affiliateLevel
            ?: AffiliateLevel::orderBy('percentage', 'asc')->first();

        if (! $affiliateLevel) {
            return;
        }

        $affiliatorCommission = $baseCommission * $affiliateLevel->percentage / 100;

        $affiliator->balance += $affiliatorCommission;
        $affiliator->save();

        // Create commission history
        CommissionHistory::create([
            'user_id' => $affiliator->id,
            'transaction_id' => $transaction->id,
            'amount' => $affiliatorCommission,
            'type' => 'affiliator',
        ]);
    }

    /**
     * calculate commission for royalti and percentage.
     */
    public static function calculateCommissionRoyalti($commission, Book $books, Transaction $transaction)
    {
        if (CommissionHistory::where('transaction_id', $transaction->id)
            ->where('type', 'royalti')
            ->exists()) {
            return;
        }

        $countAuthorModule = $books->modules->where('user_id', '!=', null)->count();
        $countAuthor = $books->authors->count();

        $writerCommission = $commission / ($countAuthorModule ?: $countAuthor);
        foreach (($countAuthorModule ? $books->modules : $books->authors) as $module) {
            if (! $module->user_id) {
                continue;
            }

            User::where('id', $module->user_id)->update([
                'balance' => DB::raw("balance + $writerCommission"),
            ]);

            // Create commission history
            CommissionHistory::create([
                'user_id' => $module->user_id,
                'transaction_id' => $transaction->id,
                'amount' => $writerCommission,
                'type' => 'royalti',
            ]);
        }
    }
}
