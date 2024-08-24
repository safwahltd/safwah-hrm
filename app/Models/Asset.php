<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $guarded;
    protected $fillable = ['asset_name','asset_id','user_id','value'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
