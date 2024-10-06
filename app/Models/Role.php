<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded;
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function rolePermissions()
    {
        return $this->belongsToMany(RolePermission::class);
    }
    public function userRoles()
    {
        return $this->belongsToMany(UserRole::class);
    }
    public function user(){
        return $this->belongsToMany(User::class,'user_roles', 'user_id');
    }
}
