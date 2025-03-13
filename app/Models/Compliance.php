<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compliance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'compliance_type_id', 'certificate_number', 'expire_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function complianceType()
    {
        return $this->belongsTo(ComplianceType::class);
    }
}
