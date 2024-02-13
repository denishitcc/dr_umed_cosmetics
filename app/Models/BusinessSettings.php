<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessSettings extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'business_settings';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'business_details_for',
        'business_name',
        'name_customers_see',
        'business_email',
        'business_phone',
        'website',
        'street_address',
        'suburb',
        'city',
        'post_code'
    ];
}
