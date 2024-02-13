<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'products';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'product_name',
        'description',
        'price',
        'cost',
        'type',
        'gst_code',
        'category_id',
        'supplier_id',
        'supplier_code',
        'barcode_1',
        'barcode_2',
        'order_lot',
        'min',
        'max'
    ];
}
