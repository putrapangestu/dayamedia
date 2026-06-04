<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function lockingTransactionDetails()
    {
        return $this->transactionDetails()->whereHas('transaction', function ($query) {
            $query->where('status', 'paid')
                ->orWhere(function ($query) {
                    $query->where('status', 'pending')
                        ->whereNotNull('expired_at')
                        ->where('expired_at', '>', now());
                });
        });
    }

    public function activePendingTransactionDetails()
    {
        return $this->transactionDetails()->whereHas('transaction', function ($query) {
            $query->where('status', 'pending')
                ->whereNotNull('expired_at')
                ->where('expired_at', '>', now());
        });
    }

    public function paidTransactionDetails()
    {
        return $this->transactionDetails()->whereHas('transaction', function ($query) {
            $query->where('status', 'paid');
        });
    }

    public function scopeAvailableForOrder($query)
    {
        return $query->where('is_active', true)
            ->whereNull('user_id')
            ->whereDoesntHave('transactionDetails.transaction', function ($query) {
                $query->where('status', 'paid')
                    ->orWhere(function ($query) {
                        $query->where('status', 'pending')
                            ->whereNotNull('expired_at')
                            ->where('expired_at', '>', now());
                    });
            });
    }

    /**
     * Get the book authors for the module.
     */
    public function authors()
    {
        return $this->hasMany(BookAuthor::class, 'module_id', 'id');
    }

    public function getOrderLockStatusAttribute(): string
    {
        if ($this->user_id !== null || $this->hasLockingTransaction('paid')) {
            return 'bought';
        }

        if (! $this->is_active) {
            return 'inactive';
        }

        if ($this->hasLockingTransaction('pending')) {
            return 'pending';
        }

        return 'available';
    }

    public function getIsLockedForOrderAttribute(): bool
    {
        return $this->order_lock_status !== 'available';
    }

    private function hasLockingTransaction(string $status): bool
    {
        if ($this->relationLoaded('transactionDetails')) {
            return $this->transactionDetails->contains(function ($detail) use ($status) {
                if (! $detail->transaction || $detail->transaction->status !== $status) {
                    return false;
                }

                if ($status === 'paid') {
                    return true;
                }

                if (! $detail->transaction->expired_at) {
                    return false;
                }

                return Carbon::parse($detail->transaction->expired_at)->isFuture();
            });
        }

        if ($status === 'paid') {
            return $this->paidTransactionDetails()->exists();
        }

        return $this->activePendingTransactionDetails()->exists();
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
