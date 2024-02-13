<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsTemplates extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'sms_templates';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'sms_template_type',
        'sms_template_description'
    ];
}
