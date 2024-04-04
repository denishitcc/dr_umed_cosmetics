<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'category_id',
        'gender_specific',
        'code',
        'appear_on_calendar',
        'standard_price',
    ];

    /**
     * Get the appearoncalender that owns the Services
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function appearoncalender(): HasOne
    {
        return $this->hasOne(ServicesAppearOnCalendar::class, 'service_id', 'id');
    }

    /**
     * Get all of the availabilities for the Services
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function availabilities(): HasMany
    {
        return $this->hasMany(ServicesAvailability::class, 'service_id', 'id');
    }

    /**
     * Get the category that owns the Services
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
