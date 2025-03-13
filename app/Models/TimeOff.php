<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeOff extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'start_date', 'end_date', 'leave_type_id', 'status_id', 'remarks'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

    public function leaveStatus()
    {
        return $this->belongsTo(LeaveStatus::class, 'status_id');
    }
}
