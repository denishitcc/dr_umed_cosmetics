<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Fortify\TwoFactorAuthenticatable;
// use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    // use HasProfilePhoto;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'phone',
        'role_type',
        'password',
        'google_id',
        'facebook_id',
        'image',
        'banner_image',
        'access_level',
        'is_staff_memeber',
        'staff_member_location',
        'last_login',
        'available_in_online_booking',
        'calendar_color'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

     /**
     * Method getNameAttribute
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        $name = '';

        if( $this->first_name )
        {
            $name = $this->first_name;
        }

        if( $this->last_name )
        {
            $name .= " ".$this->last_name;
        }

        return $name;
    }

    /**
     * Get the staff_location that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staff_location(): BelongsTo
    {
        return $this->belongsTo(Locations::class, 'staff_member_location', 'id');
    }
}
