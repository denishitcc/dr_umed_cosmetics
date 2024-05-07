<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalkInRetailSale extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'walk_in_retail_sale';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'client_id',
        'location_id',
        'appt_id',
        'invoice_date',
        'subtotal',
        'discount',
        'gst',
        'total',
        'remaining_balance',
        'user_id',
        'note',
        'customer_type',
        'walk_in_type'
    ];
}
