<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'payment';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'walk_in_id',
        'payment_type',
        'amount',
        'date',
    ];
}
