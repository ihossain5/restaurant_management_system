<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantDeliveryLocation extends Model
{
    use HasFactory;

    protected $fillable = ['restaurant_id','delivery_location_id','delivery_fee'];

    public function restaurant(){
       return $this->belongsTo(Restaurant::class,'restaurant_id');
    }

    public function location(){
      return $this->belongsTo(DeliveryLocation::class,'delivery_location_id');
    }
}
