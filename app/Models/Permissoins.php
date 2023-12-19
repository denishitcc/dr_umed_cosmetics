<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permissoins extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'appointments_and_clients',
        'targets',
        'limited',
        'standard',
        'standard+',
        'advance',
        'advance+',
        'accounts'
    ];
}
