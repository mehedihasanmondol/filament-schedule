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
    // Define the many-to-many relationship with Permission
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'role_permissions');
    }

    // public function rolePermissions()
    // {
    //     return $this->hasMany(RolePermission::class);
    // }
}
