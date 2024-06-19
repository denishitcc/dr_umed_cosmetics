<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workinghours extends Model
{
    use HasFactory;

    /** @var string $table */
    protected $table = 'working_hours';

    protected $fillable = [
        'id',
        'staff_id',
        'working_status',
        'working_start_time',
        'working_end_time',
        'lunch_start_time',
        'lunch_duration',
        'break_start_time',
        'break_duration',
        'custom_start_time',
        'custom_end_time',
        'custom_reason',
        'leave_reason',
        'leave_start_date',
        'leave_end_date',
        'calendar_date',
        'paid_time'
    ];

    const WORKING           = 1;
    const NOT_WORKING       = 0;
    const LEAVE             = 2;
    const PARTIAL_LEAVE     = 3;

    const NONE      = 1;
    const ANNUAL    = 2;
    const PUBLIC    = 3;
    const SICK      = 4;
    const UNPAID    = 5;

    const STATUS = [
        self::WORKING           => 'Working',
        self::NOT_WORKING       => 'Not Working',
        self::LEAVE             => 'Leave',
        self::PARTIAL_LEAVE     => 'Partial Leave',
    ];

    const LEAVE_STATUS = [
        self::NONE           => 'None(unpaid)',
        self::ANNUAL         => 'Annual Leave',
        self::PUBLIC         => 'Public Leave',
        self::SICK           => 'Sick Leave',
        self::UNPAID         => 'Unpaid Leave',
    ];

      /**
     * Method getColorAttribute
     *
     * @return string
     */
    public function getColorAttribute(): string
    {
        $color = '';
        $status = $this->working_status;

        switch ($status) {
            case 0:
                $color = '#0076bc';
                break;
            case 1:
                $color = '#0076bc';
                break;
            case 2:
                $color = '#fdc02f';
                break;
            case 3:
                $color = '#e46c8a';
                break;
            default:
                $color = '#0076bc';
                break;
        }

        return $color;
    }
}
