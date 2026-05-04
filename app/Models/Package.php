<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    public $fillable = ['name_en', 'name_ar','duration','price','status'];


    function subscriptions_package_users()
    {
        return $this->hasMany(SubscriptionsPackageUser::class, 'package_id');
    }


    public function subscriptions()
    {
        return $this->hasMany(SubscriptionsPackageClinic::class);
    }

}
