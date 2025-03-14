<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'category_id']; // Include category_id and slug

    // Define the many-to-many relationship with Role
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    // Define the inverse relationship with PermissionCategory
    public function category()
    {
        return $this->belongsTo(PermissionCategory::class);
    }
}
