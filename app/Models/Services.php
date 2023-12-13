<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'service_name',
        'parent_category',
        'gender_specific',
        'code',
        'appear_on_calendar',
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
        'follow_on_services',
        'standard_price',
        'apprentice',
        'junior',
        'intermidiate',
        'senior',
        'very_senior',
        'gst_code',
        'concession',
        'chatwood',
        'branch_standard_price',
        'branch_apprentice',
        'branch_junior',
        'branch_intermidiate',
        'branch_senior',
        'branch_very_senior',
        'ipswitch',
        'hope_island',
        'paddingtone',
        'regents_park',
        'sunshine_coast',
        'greenacre',
        'surfers_paradise',
        'staff_price'
    ];
}
