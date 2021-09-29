<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $primaryKey = 'customer_id';
    protected $fillable = ['name','photo','sex','email','password','contact','is_banned','address'];

    public function orders(){
        return $this->hasMany(Order::class,'customer_id');
    }
}
