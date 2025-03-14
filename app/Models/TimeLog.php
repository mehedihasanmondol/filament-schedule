<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'site_id',
        'date',
        'shift_start',
        'shift_end',
        'hourly_rate',
        'total_pay',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public static function boot()
    {
        parent::boot();
        static::saving(function ($timelog) {
            $start = strtotime($timelog->shift_start);
            $end = strtotime($timelog->shift_end);
            $hoursWorked = ($end - $start) / 3600;
            $timelog->hours_worked = $hoursWorked;
            $timelog->total_payable = $hoursWorked * $timelog->hourly_rate;
        });
    }
}
