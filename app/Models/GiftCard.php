<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    use HasFactory;

    /** @var string $table */
    protected $table = 'gift_cards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'tracking_number',
        'value',
        'expiry_date',
        'notes',
        'remaining_value',
        'purchase_date',
        'last_used',
        'expired',
        'cancelled',
        'purchase_at',
        'recipient',
        'cancelled_at'
    ];
}
