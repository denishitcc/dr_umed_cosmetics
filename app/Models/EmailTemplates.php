<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplates extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'email_templates';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'email_template_type',
        'subject',
        'email_template_description'
    ];
}
