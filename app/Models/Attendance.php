<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $guarded = ['user_id', 'clock_in', 'clock_out'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
