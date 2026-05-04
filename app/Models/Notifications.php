<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    public $fillable = ['admin_id','user_id','clinic_id','receiver_id','type','app_type','image','title_en', 'title_ar','message_en','message_ar','status'];


    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('media/clinics/' . $value);
        } else {
            return asset('media/clinics/user.png');
        }
    }

    public function setImageAttribute($value)
    {
        if ($value) {
            $img_name = time() . rand(1111, 9999) . '.' . $value->getClientOriginalExtension();
            $value->move(public_path('media/clinics/'), $img_name);
            $this->attributes['image'] = $img_name;
        }
    }

    public function admin()
    {
        return $this->belongsTo(Clinic::class,'admin_id');
    }

    public function clinics()
    {
        return $this->hasMany(Clinic::class,'clinic_id');
    }


}
