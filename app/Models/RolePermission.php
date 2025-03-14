<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $fillable = ['permission_id', 'role_id']; // Include permission_id and role_id

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions', 'permission_id', 'role_id');
    }
    public function permission(){
        return $this->belongsTo(Permission::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
}
