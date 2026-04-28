<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffiliateLevel extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'affiliate_levels';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'percentage',
        'min_earning',
        'description',
        'icon',
    ];

    /**
     * Get the users for the affiliate level.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'affiliate_level');
    }
}
