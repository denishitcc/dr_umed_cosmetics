<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enquiries extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'enquiries';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
