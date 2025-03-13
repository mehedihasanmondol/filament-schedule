<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['logo', 'name', 'email', 'contact_person', 'number'];

    public function sites()
    {
        return $this->hasMany(Site::class);
    }
}
