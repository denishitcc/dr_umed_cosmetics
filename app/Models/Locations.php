<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locations extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'locations';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
