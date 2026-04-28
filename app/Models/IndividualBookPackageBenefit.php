<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndividualBookPackageBenefit extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'individual_book_package_benefits';

    protected $fillable = [
        'package_id',
        'benefit_name',
        'benefit_value',
        'sort_order',
    ];

    public function package()
    {
        return $this->belongsTo(IndividualBookPackage::class, 'package_id');
    }
}
