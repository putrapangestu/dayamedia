<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndividualBookPackage extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'individual_book_packages';

    protected $fillable = [
        'name',
        'price',
        'description',
        'max_authors_default',
        'status',
    ];

    public function benefits()
    {
        return $this->hasMany(IndividualBookPackageBenefit::class, 'package_id');
    }

    public function authorAddons()
    {
        return $this->hasMany(IndividualBookAuthorAddon::class, 'package_id');
    }
}
