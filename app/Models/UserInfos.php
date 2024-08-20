<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfos extends Model
{
    use HasFactory;
    protected $guarded;
    public function designations(){
        return $this->belongsTo(Designation::class,'designation','id');
    }
}
