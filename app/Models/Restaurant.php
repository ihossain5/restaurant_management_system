<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    protected $primaryKey = 'restaurant_id';
    protected $fillable = [
        'name',
        'type',
        'description',
        'is_open',
        'contact',
        'email',
        'address',
    ];

    public function assets(){
        return $this->belongsToMany(AssetType::class,'asset_restaurants','restaurant_id','asset_type_id')->withPivot('asset_restaurant_id','asset')->withTimestamps();
    }
}
