<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicesAvailability extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'services_availabilities';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'service_id',
        'category_id',
        'location_name',
        'availability'
    ];
}
