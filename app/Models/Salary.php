<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    /*protected $fillable = [
        'user_id', 'basic_salary', 'allowances', 'deductions', 'status'
    ];*/
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function userInfo()
    {
        return $this->belongsTo(UserInfos::class,'user_id','user_id');
    }

    public function salaryPayments()
    {
        return $this->hasMany(SalaryPayment::class);
    }
}
