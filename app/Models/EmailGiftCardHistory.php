<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailGiftCardHistory extends Model
{
    use HasFactory;

    /** @var string $table */
    protected $table = 'email_gift_card_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'tracking_number',
        'email',
        'sent_by',
        'send_date'
    ];
}
