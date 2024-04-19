<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalkInProducts extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'walk_in_products';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'walk_in_id',
        'product_id',
        'product_name',
        'product_price',
        'product_quantity',
        'product_type',
        'who_did_work',
        'product_discount_surcharge',
        'discount_type',
        'discount_amount',
        'discount_reason',
        'type',
        'discount_value',
    ];
}
