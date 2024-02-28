<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'appointment';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'client_id',
        'category_id',
        'service_id',
        'staff_id',
        'start_date',
        'end_date',
        'duration',
        'status'
    ];

    const BOOKED        = 1;
    const CONFIRMED     = 2;
    const STARTED       = 3;
    const COMPLETED     = 4;
    const NO_ANSWER     = 5;
    const LEFT_MESSAGE  = 6;
    const PENCILIED_IN  = 7;
    const TURNED_UP     = 8;
    const NO_SHOW       = 9;
    const CANCELLED     = 10;

    const APPOINTMENT_STATUS = [
        self::BOOKED        => 'Booked',
        self::CONFIRMED     => 'Confirmed',
        self::STARTED       => 'Started',
        self::COMPLETED     => 'Completed',
        self::NO_ANSWER     => 'No answer',
        self::LEFT_MESSAGE  => 'Left Message',
        self::PENCILIED_IN  => 'Pencilied In',
        self::TURNED_UP     => 'Turned Up',
        self::NO_SHOW       => 'No Show',
        self::CANCELLED     => 'Cancelled',
    ];

    /**
     * Method getAppointmentStatusAttribute
     *
     * @return string
    */
    public function getAppointmentStatusAttribute(): string
    {
        return self::APPOINTMENT_STATUS[$this->status];
    }

    /**
     * Get all of the services for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function services(): belongsTo
    {
        return $this->belongsTo(Services::class, 'service_id', 'id');
    }

    /**
     * Get the clients that owns the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clients(): BelongsTo
    {
        return $this->belongsTo(Clients::class, 'client_id', 'id');
    }

    /**
     * Get the staff that owns the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }

    /**
     * Get the notes that owns the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function notes(): hasOne
    {
        return $this->hasOne(AppointmentNotes::class, 'appointment_id', 'id');
    }

}
