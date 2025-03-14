<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'remarks'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }

    public function userRoles()
    {
        return $this->hasMany(UserRole::class);
    }
}
