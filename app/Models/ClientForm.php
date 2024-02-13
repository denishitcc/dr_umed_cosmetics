<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientForm extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'client_form';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'form_summary_id',
        'reason_for_consultations',
        'how_long_concern',
        'age',
        'treat',
        'treat_yes',
        'taking_medication',
        'medication_yes',
        'product_taking',
        'ipl_hair_removal',
        'hair_removal_method',
        'sign',
        'date'
    ];
}
