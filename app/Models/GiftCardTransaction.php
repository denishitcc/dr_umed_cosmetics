<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCardTransaction extends Model
{
    use HasFactory;

    /** @var string $table */
    protected $table = 'gift_card_transaction';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'gift_card_id',
        'date_time',
        'location_name',
        'redeemed_value',
        'redeemed_value_type',
        'redeemed_by',
        'invoice_number'
    ];
}
