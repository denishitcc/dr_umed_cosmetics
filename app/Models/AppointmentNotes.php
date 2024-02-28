<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentNotes extends Model
{
    use HasFactory;

    /** @var string $table */
    protected $table = 'appointments_notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'appointment_id',
        'common_notes',
        'treatment_notes',
    ];
}
