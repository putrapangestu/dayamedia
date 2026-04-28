<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookAuthor extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'book_authors';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'module_id',
        'book_id',
        'author',
        'user_id',
    ];

    /**
     * Get the book that owns the book author.
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id')->withTrashed();
    }

    /**
     * Get the user that owns the book author.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the module that owns the book author.
     */
    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
}
