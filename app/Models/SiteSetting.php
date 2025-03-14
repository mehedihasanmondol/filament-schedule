<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_logo',
        'site_favicon',
        'contact_email',
        'contact_phone',
        'address',
        'currency',
    ];
}
