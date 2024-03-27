<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WaitlistClient extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'waitlist_client';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'client_id',
        'user_id',
        'preferred_from_date',
        'preferred_to_date',
        'additional_notes',
        'category_id',
        'service_id',
    ];
}
