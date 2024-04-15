<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationDiscount extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'location_discount';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'location_id',
        'discount_type',
        'discount_percentage',
    ];
}
