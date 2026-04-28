<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'book_id',
        'quantity',
        'type',
    ];

    /**
     * Get the book that belongs to the cart.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the user that belongs to the cart.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
