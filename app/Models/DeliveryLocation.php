<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryLocation extends Model
{
    use HasFactory;
    protected $primaryKey = 'delivery_location_id';

    protected $fillable = ['name'];

    public function restaurants(){
        return $this->belongsToMany(Restaurant::class,'restaurant_delivery_locations', 'delivery_location_id','restaurant_id');
    }
}
