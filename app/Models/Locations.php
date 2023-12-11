<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    use HasFactory;

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
