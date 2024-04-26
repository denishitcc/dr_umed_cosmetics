<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicesAppearOnCalendar extends Model
{
    use HasFactory,SoftDeletes;
    // use SoftDeletes;

    /** @var string $table */
    protected $table = 'services_appear_on_calendars';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'service_id',
        'duration',
        'processing_time',
        'fast_duration',
        'slow_duration',
        'usual_next_service',
        'dont_include_reports',
        'technical_service',
        'available_on_online_booking',
        'require_a_room',
        'unpaid_time',
        'require_a_follow_on_service',
        'follow_on_services',
    ];
}