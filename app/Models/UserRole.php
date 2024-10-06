<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    protected $guarded;
    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }
    public function user(){
        return $this->hasOne(User::class);
    }
    public function rolePermission(){
        return $this->hasMany(RolePermission::class,'role_id','role_id');
    }
}
