<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookHistory extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'book_histories';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'book_id',
        'user_id',
        'expired_at',
    ];

    /**
     * Get the book that the history belongs to.
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id')->withTrashed();
    }

    /**
     * Get the user that the history belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
}
