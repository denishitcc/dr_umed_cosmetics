<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

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
