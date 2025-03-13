<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'contact_name', 'number', 'client_id', 'status'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function inductedSites()
    {
        return $this->hasMany(InductedSite::class);
    }
}
