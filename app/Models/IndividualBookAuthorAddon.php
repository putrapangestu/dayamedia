<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndividualBookAuthorAddon extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'individual_book_author_addons';

    protected $fillable = [
        'package_id',
        'additional_author_price',
        'status',
    ];

    public function package()
    {
        return $this->belongsTo(IndividualBookPackage::class, 'package_id');
    }
}
