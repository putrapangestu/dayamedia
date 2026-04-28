<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, HasUuids, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'referral_code',
        'phone_number',
        'email_verified_at',
        'affiliate_level_id',
        'job',
        'degree',
        'photo',
        'address',
        'use_referral_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the affiliate level for the user.
     */
    public function affiliateLevel()
    {
        return $this->belongsTo(AffiliateLevel::class, 'affiliate_level_id')->withTrashed();
    }

    /**
     * Get the carts for the user.
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the transactions for the user.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the modules for the user.
     */
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    /**
     * Get the commission histories for the user.
     */
    public function commissionHistories()
    {
        return $this->hasMany(CommissionHistory::class);
    }

    /**
     * Get the book histories for the user.
     */
    public function bookHistories()
    {
        return $this->hasMany(BookHistory::class);
    }

    /**
     * Get the book editor records for the user.
     */
    public function bookEditors()
    {
        return $this->hasMany(BookEditor::class);
    }

    /**
     * Get the withdraws for the user.
     */
    public function withdraws()
    {
        return $this->hasMany(Withdraw::class);
    }
}
