<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function checkedBy(){
        return $this->belongsTo(User::class,'checked_by','id');
    }
    public function approvedBy(){
        return $this->belongsTo(User::class,'approved_by','id');
    }
    public function receivedBy(){
        return $this->belongsTo(User::class,'received_by','id');
    }
}
