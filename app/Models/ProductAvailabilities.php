<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAvailabilities extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'product_availabilities';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'product_id',
        'location_name',
        'min',
        'max',
        'price',
        'availability'
    ];
}
