<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Royalty;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;

class RoyaltyController extends Controller
{
    /**
     * Display a listing of the royalties.
     */
    public function index(Request $request)
    {
        $royalties = Royalty::with(['user', 'book', 'transaction', 'transactionDetail'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($request->user_id, function ($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->latest()
            ->paginate(10);

        $users = User::role('editor')->get();

        return view('admin.pages.royalty.index', compact('royalties', 'users'));
    }

    /**
     * Display the specified royalty.
     */
    public function show(string $id)
    {
        $royalty = Royalty::with(['user', 'book', 'transaction', 'transactionDetail'])->findOrFail($id);

        return view('admin.pages.royalty.show', compact('royalty'));
    }

    /**
     * Process royalty payment.
     */
    public function processPayment(Request $request, string $id)
    {
        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes' => 'nullable|string|max:500',
        ]);

        $royalty = Royalty::findOrFail($id);

        if ($royalty->status !== Royalty::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Royalty sudah diproses.');
        }

        // Store payment proof
        $paymentProof = $request->file('payment_proof')->store('royalty_payments', 'public');

        $royalty->update([
            'status' => Royalty::STATUS_PAID,
            'payment_proof' => $paymentProof,
            'paid_at' => now(),
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Pembayaran royalty berhasil diproses.');
    }

    /**
     * Show royalty settings page.
     */
    public function settings()
    {
        $royaltyStats = [
            'paid_royalty' => Royalty::where('status', 'paid')->sum('amount'),
            'pending_royalty' => Royalty::where('status', 'pending')->sum('amount'),
            'paid_referral' => Royalty::where('type', 'referral')->where('status', 'paid')->sum('amount'),
            'pending_referral' => Royalty::where('type', 'referral')->where('status', 'pending')->sum('amount'),
        ];

        return view('admin.pages.royalty.settings', compact('royaltyStats'));
    }

    /**
     * Update royalty settings.
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'royalty_percentage' => 'required|numeric|min:0|max:100',
            'referral_percentage' => 'required|numeric|min:0|max:100',
            'min_withdrawal' => 'required|numeric|min:0',
            'payment_terms' => 'nullable|string|max:2000',
        ]);

        setting_set('royalty_percentage', $request->royalty_percentage, 'decimal', 'Persentase royalty untuk author/editor', 'royalty');
        setting_set('referral_percentage', $request->referral_percentage, 'decimal', 'Persentase referral untuk user yang mereferensikan', 'royalty');
        setting_set('min_withdrawal', $request->min_withdrawal, 'integer', 'Minimum jumlah untuk penarikan royalty', 'royalty');
        setting_set('payment_terms', $request->payment_terms, 'text', 'Syarat dan ketentuan pembayaran royalty', 'royalty');

        return redirect()->back()->with('success', 'Pengaturan royalty berhasil diperbarui.');
    }

    /**
     * Calculate royalties for a transaction.
     */
    public static function calculateRoyalties(Transaction $transaction)
    {
        foreach ($transaction->details as $detail) {
            if ($detail->module) {
                // Calculate royalty for book author/editor
                self::createBookRoyalty($detail);
            }

            // Calculate referral commission
            if ($transaction->user->referrer) {
                self::createReferralRoyalty($detail, $transaction->user->referrer);
            }
        }
    }

    /**
     * Create royalty for book author/editor.
     */
    private static function createBookRoyalty(TransactionDetail $detail)
    {
        $module = $detail->module;
        if (! $module || ! $module->user_id) {
            return;
        }

        // Get royalty percentage from settings (default 10%)
        $royaltyPercentage = (float) setting('royalty_percentage', 10);
        $royaltyAmount = ($detail->price * $royaltyPercentage) / 100;

        Royalty::create([
            'user_id' => $module->user_id,
            'book_id' => $module->book_id,
            'transaction_id' => $detail->transaction_id,
            'transaction_detail_id' => $detail->id,
            'amount' => $royaltyAmount,
            'percentage' => $royaltyPercentage,
            'type' => Royalty::TYPE_ROYALTY,
            'description' => "Royalti dari penjualan bab '{$module->title}' buku '{$module->book->title}'",
            'status' => Royalty::STATUS_PENDING,
        ]);
    }

    /**
     * Create referral royalty.
     */
    private static function createReferralRoyalty(TransactionDetail $detail, User $referrer)
    {
        // Get referral percentage from settings (default 5%)
        $referralPercentage = (float) setting('referral_percentage', 5);
        $referralAmount = ($detail->price * $referralPercentage) / 100;

        Royalty::create([
            'user_id' => $referrer->id,
            'book_id' => $detail->module->book_id,
            'transaction_id' => $detail->transaction_id,
            'transaction_detail_id' => $detail->id,
            'amount' => $referralAmount,
            'percentage' => $referralPercentage,
            'type' => Royalty::TYPE_REFERRAL,
            'description' => "Komisi referral dari pembelian buku '{$detail->module->book->title}' oleh {$detail->transaction->user->full_name}",
            'status' => Royalty::STATUS_PENDING,
        ]);
    }
}
