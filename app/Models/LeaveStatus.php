<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'color', 'remarks'];

    public function timeOffs()
    {
        return $this->hasMany(TimeOff::class);
    }
}
