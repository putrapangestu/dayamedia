<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'books';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
        'price_digital',
        'price_physical',
        'stock',
        'code_isbn',
        'status',
        'publisher',
        'year_published',
        'language',
        'pages',
        'weight',
        'cover',
        'full_content',
        'half_content',
        'category_id',
        'slug',
        'editor',
        'website',
        'google_scholar_url',
        'is_individual',
    ];

    /**
     * The status of the book.
     */
    public const STATUS_CLOSED = 'closed';

    public const STATUS_EDITING = 'editing';

    public const STATUS_ARCHIVED = 'archived';

    public const STATUS_PUBLISHED = 'published';

    public const STATUS_UNPUBLISHED = 'unpublished';

    public const STATUS_OPEN = 'open';

    /**
     * Get the category that owns the book.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the authors for the book.
     */
    public function authors()
    {
        return $this->hasMany(BookAuthor::class);
    }

    /**
     * Get the carts for the book.
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the modules for the book.
     */
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    /**
     * Get the book editors for the book.
     */
    public function bookEditors()
    {
        return $this->hasOne(BookEditor::class);
    }

    /**
     * Get the book transaction
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function promos()
    {
        return $this->belongsToMany(Promo::class, 'promo_book', 'book_id', 'promo_id');
    }
}
