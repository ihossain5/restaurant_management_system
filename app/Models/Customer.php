<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Customer  extends Authenticatable
{
    use HasFactory;
    protected $primaryKey = 'customer_id';
    protected $fillable = ['name','photo','sex','email','password','contact','is_banned','address'];

    public function orders(){
        return $this->hasMany(Order::class,'customer_id');
    }

    public function setPasswordAttribute($pass) {
        $this->attributes['password'] = Hash::make($pass);
    }
}
