<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model {
    use HasFactory;
    protected $primaryKey = 'restaurant_id';
    protected $fillable   = [
        'name',
        'type',
        'description',
        'is_open',
        'contact',
        'email',
        'address',
        'user_id',
        'logo',
    ];

    public function assets() {
        return $this->belongsToMany(AssetType::class, 'asset_restaurants', 'restaurant_id', 'asset_type_id')->withPivot('asset_restaurant_id', 'asset')->withTimestamps();
    }
    public function restaurant_categories() {
        return $this->hasMany(Category::class, 'restaurant_id')->orderBy('created_at', 'DESC');
    }
    public function restaurant_items() {
        return $this->hasManyThrough(Item::class, Category::class, 'restaurant_id', 'category_id')->with('category', 'item_assets')->orderBy('created_at', 'DESC');
    }
    


}
