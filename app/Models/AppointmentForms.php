<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AppointmentForms extends Model
{
    use HasFactory;

    /** @var string $table */
    protected $table = 'appointment_forms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'appointment_id',
        'form_id',
        'status',
        'form_user_data',
    ];

    const NEW         = 0;
    const IN_PRORESS  = 1;
    const COMPLETED   = 2;

    /**
     * Get the forms associated with the AppointmentForms
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function forms(): BelongsTo
    {
        return $this->belongsTo(FormSummary::class, 'form_id', 'id');
    }

    /**
     * Get the appointment that owns the AppointmentForms
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }
}
