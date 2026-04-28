<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'modules';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'title',
        'slug',
        'chapter',
        'days',
        'deadline',
        'deadline_date',
        'deadline_type',
        'is_overdue',
        'description',
        'price',
        'is_active',
        'user_id',
        'book_id',
        'file_path',
        'file_path_turnitin',
    ];

    /**
     * Get the user that owns the module.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that owns the module.
     */
    public function book()
    {
        return $this->belongsTo(Book::class)->withTrashed();
    }

    /**
     * Get the transaction details for the module.
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Get the book authors for the module.
     */
    public function authors()
    {
        return $this->hasMany(BookAuthor::class, 'module_id', 'id');
    }

    /**
     * Get the actual deadline date.
     */
    public function getActualDeadlineAttribute()
    {
        if ($this->deadline_type === 'date' && $this->deadline_date) {
            return $this->deadline_date;
        } elseif ($this->days && $this->created_at) {
            return $this->created_at->addDays($this->days);
        }

        return null;
    }

    /**
     * Check if the module is overdue.
     */
    public function getIsOverdueAttribute()
    {
        $deadline = $this->actual_deadline;

        return $deadline && now()->greaterThan($deadline);
    }
}
