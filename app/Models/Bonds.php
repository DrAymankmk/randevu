<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonds extends Model
{
    use HasFactory;

    public $fillable = ['user_id', 'account_type','price', 'notes','reception_id','account_id','movement_type','date','payment_method'];

    function user()
    {
        return $this->belongsTo(User::class,'user_id');

    }

}
