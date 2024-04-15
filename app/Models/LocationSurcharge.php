<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationSurcharge extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'location_surcharge';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'location_id',
        'surcharge_type',
        'surcharge_percentage'
    ];
}
