<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'business_details_for',
        'business_name',
        'name_customers_see',
        'business_email',
        'business_phone',
        'website',
        'city',
        'post_code'
    ];
}
