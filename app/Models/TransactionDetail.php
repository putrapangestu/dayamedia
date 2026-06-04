<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetail extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'transaction_details';

    protected $fillable = [
        'transaction_id',
        'book_id',
        'module_id',
        'quantity',
        'type',
        'price_book',
        'price_discount',
    ];

    /**
     * Get the transaction that belongs to the transaction detail.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Get the book that belongs to the transaction detail.
     */
    public function book()
    {
        return $this->belongsTo(Book::class)->withTrashed();
    }

    /**
     * Get the module that belongs to the transaction detail.
     */
    public function module()
    {
        return $this->belongsTo(Module::class)->withTrashed();
    }
}
