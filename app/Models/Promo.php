<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promo extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'promos';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'code',
        'percentage',
        'quantity',
        'start_date',
        'end_date',
        'description',
    ];

    /**
     * Get all of the histories for the Promo
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function histories()
    {
        return $this->hasMany(PromoHistory::class, 'promo_id', 'id');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'promo_book', 'promo_id', 'book_id');
    }
}
