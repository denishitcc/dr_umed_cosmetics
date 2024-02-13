<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessWorkingHours extends Model
{
    use HasFactory;
    // use SoftDeletes;
    // protected $dates = ['deleted_at'];

    /** @var string $table */
    protected $table = 'busines_working_hours';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'location_id',
        'day',
        'start_time',
        'end_time',
        'day_status'
    ];
}
