<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enquiries extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'firstname',
        'lastname',
        'gender',
        'email',
        'phone_number',
        'enquiry_date',
        'appointment_date',
        'about_us',
        'enquiry_source',
        'cosmetic_injectables',
        'skin',
        'surgical',
        'body',
        'comments',
        'enquiry_status',
        'location_name'
    ];
}
