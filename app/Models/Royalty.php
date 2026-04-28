<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Royalty extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'royalties';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'book_id',
        'transaction_id',
        'transaction_detail_id',
        'amount',
        'percentage',
        'type', // 'referral', 'royalty'
        'description',
        'status', // 'pending', 'paid', 'cancelled'
        'paid_at',
        'payment_proof',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'percentage' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the user associated with the royalty.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book associated with the royalty.
     */
    public function book()
    {
        return $this->belongsTo(Book::class)->withTrashed();
    }

    /**
     * Get the transaction associated with the royalty.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Get the transaction detail associated with the royalty.
     */
    public function transactionDetail()
    {
        return $this->belongsTo(TransactionDetail::class);
    }

    /**
     * Get status constants
     */
    public const STATUS_PENDING = 'pending';

    public const STATUS_PAID = 'paid';

    public const STATUS_CANCELLED = 'cancelled';

    /**
     * Get type constants
     */
    public const TYPE_REFERRAL = 'referral';

    public const TYPE_ROYALTY = 'royalty';
}
