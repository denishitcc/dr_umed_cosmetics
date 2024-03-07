<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clients extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'clients';

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
        'date_of_birth',
        'mobile_number',
        'home_phone',
        'work_phone',
        'contact_method',
        'send_promotions',
        'street_address',
        'suburb',
        'city',
        'postcode',
        'status'
    ];

    /**
     * Get the last_appointment associated with the Clients
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function last_appointment(): HasOne
    {
        return $this->hasOne(Appointment::class, 'client_id', 'id')->latest();
    }


    /**
     * Method getNameAttribute
     *
     * @return string
    */
    public function getNameAttribute(): string
    {
        $name = '';

        if( $this->firstname )
        {
            $name = $this->firstname;
        }

        if( $this->lastname )
        {
            $name .= " ".$this->lastname;
        }

        return $name;
    }

    /**
     * Get all of the allAppointments for the Clients
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'client_id', 'id');
    }

    /**
     * Get all of the photos for the Clients
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos(): HasMany
    {
        return $this->hasMany(ClientsPhotos::class, 'client_id', 'id');
    }

    /**
     * Get all of the documents for the Clients
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents(): HasMany
    {
        return $this->hasMany(ClientsDocuments::class, 'client_id', 'id');
    }
}
