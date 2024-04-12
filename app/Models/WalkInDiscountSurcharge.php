<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalkInDiscountSurcharge extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'walk_in_discount_surcharge';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'walk_in_id',
        'discount_surcharge',
        'discount_type',
        'discount_amount',
        'discount_reason',
    ];
}
