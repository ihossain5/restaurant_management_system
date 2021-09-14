<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetRestaurant extends Model
{
    use HasFactory;
    protected $primaryKey = 'asset_restaurant_id';
    protected $fillable = [
        'restaurant_id',
        'asset_type_id',
        'asset',
    ];
}
