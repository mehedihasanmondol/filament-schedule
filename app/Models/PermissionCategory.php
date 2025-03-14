<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    // Define the one-to-many relationship with Permission
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
