<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'services';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'service_name',
        'parent_category',
        'gender_specific',
        'code',
        'appear_on_calendar',
        'standard_price',
    ];
}
