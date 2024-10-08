<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingTime extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'date_checkin', 'time_checkin', 'time_checkout'];
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}

