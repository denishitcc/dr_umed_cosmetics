<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clients extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'clients';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'firstname',
        'lastname',
        'gender',
        'email',
        'date_of_birth',
        'mobile_number',
        'home_phone',
        'work_phone',
        'contact_method',
        'send_promotions',
        'street_address',
        'suburb',
        'city',
        'postcode',
        'status'
    ];
}
