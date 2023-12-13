<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormSummary extends Model
{
    use HasFactory;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'title',
        'description',
        'by_whom',
        'status'
    ];
}
