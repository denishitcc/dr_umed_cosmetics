<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suppliers extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'suppliers';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'business_name',
        'contact_first_name',
        'contact_last_name',
        'home_phone',
        'work_phone',
        'fax_numbers',
        'mobile_phone',
        'email',
        'web_address',
        'street_address',
        'suburb',
        'city',
        'state',
        'post_code',
        'country'
    ];
}
