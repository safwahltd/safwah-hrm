<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userInfo(){
        return $this->hasOne(UserInfos::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }
    public function role()
    {
        return $this->hasOne(Role::class);
    }
    public function userRoles()
    {
        return $this->hasMany(UserRole::class);
    }

    public function hasPermission($permission)
    {
        if (auth()->user()->role == 'admin'){
            return true;
        }
        $user_Roles = UserRole::where('user_id',auth()->user()->id)->get();
        foreach ($user_Roles as $user_Role) {
            foreach ($user_Role->rolePermission as $permit){
                if ($permit->permission->status == 1){
                    if ($permit->permission->name == $permission){
                        return true;
                    }
                }
            }
        }
        return false;
    }
    public function salary()
    {
        return $this->hasOne(Salary::class);
    }

    public function salaryPayments()
    {
        return $this->hasMany(SalaryPayment::class);
    }
}
