<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplianceType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'remarks', 'is_required'];

    public function complianceRecords()
    {
        return $this->hasMany(Compliance::class);
    }
}
