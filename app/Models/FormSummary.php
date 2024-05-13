<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormSummary extends Model
{
    use HasFactory;

    /** @var string $table */
    protected $table = 'form_summaries';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'description',
        'form_json',
        'by_whom',
        'status'
    ];

    const DRAFT  = 0;
    const LIVE   = 1;
}
