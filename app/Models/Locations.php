<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locations extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'location_name',
        'phone',
        'email',
        'street_address',
        'suburb',
        'city',
        'state',
        'postcode',
        'latitude',
        'longitude'
    ];
}
