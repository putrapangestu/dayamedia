<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'payment_method',
        'transaction_code',
        'payment_proof',
        'note',
        'promo_code',
        'discount_amount',
        'admin_fee',
        'expired_at',
        'individual_book_package_id',
        'additional_authors_count',
        'individual_book_status',
        'individual_book_confirmed_at',
        'individual_book_rejected_at',
        'individual_book_rejected_reason',
    ];

    protected function casts(): array
    {
        return [
            'reminder_sent_at' => 'datetime',
            'expired_at' => 'datetime',
            'individual_book_confirmed_at' => 'datetime',
            'individual_book_rejected_at' => 'datetime',
        ];
    }

    /**
     * Get the user that belongs to the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the transaction details that belongs to the transaction.
     */
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Get the commission histories that belongs to the transaction.
     */
    public function commissionHistories()
    {
        return $this->hasMany(CommissionHistory::class);
    }

    public function individualBookPackage()
    {
        return $this->belongsTo(IndividualBookPackage::class, 'individual_book_package_id');
    }

    /**
     * Apply promo code to transaction
     */
    public function applyPromoCode($code)
    {
        $promo = \App\Models\Promo::where('code', $code)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('quantity', '>', 0)
            ->first();

        if (! $promo) {
            return false;
        }

        // Check if promo has been used by this user
        $usedCount = \App\Models\PromoHistory::where('promo_id', $promo->id)
            ->where('user_id', $this->user_id)
            ->count();

        if ($usedCount > 0) {
            return false;
        }

        $boundBookIds = $promo->books()->pluck('books.id')->all();
        if (! empty($boundBookIds)) {
            $cartBookIds = $this->details()->pluck('book_id')->filter()->unique()->values()->all();
            $hasBoundBookInCart = collect($cartBookIds)->intersect($boundBookIds)->isNotEmpty();
            if (! $hasBoundBookInCart) {
                return false;
            }
        }

        $discountAmount = ($this->total_price * $promo->percentage) / 100;
        $newTotalPrice = $this->total_price - $discountAmount;

        $this->update([
            'promo_code' => $code,
            'discount_amount' => $discountAmount,
            'total_price' => max($newTotalPrice, 0), // Ensure price doesn't go negative
        ]);

        // Record promo usage
        \App\Models\PromoHistory::create([
            'promo_id' => $promo->id,
            'user_id' => $this->user_id,
            'transaction_id' => $this->id,
            'discount_amount' => $discountAmount,
        ]);

        // Decrease promo quantity
        $promo->decrement('quantity');

        return true;
    }
}
