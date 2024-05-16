<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permissions extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'permissions';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'sub_name',
        'targets',
        'limited',
        'standard',
        'standardplus',
        'advance',
        'advanceplus',
        'admin',
        'account'
    ];
}
