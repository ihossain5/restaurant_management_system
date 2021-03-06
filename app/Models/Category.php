<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use HasFactory;
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'restaurant_id',
        'name',
        'description',
    ];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class,'restaurant_id');
    }
    public function items(){
        return $this->hasMany(Item::class, 'category_id')->with('item_assets','category');
    }

    public function available_items(){
        return $this->hasMany(Item::class, 'category_id')->with('item_assets','category')->where('is_available',1);
    }
}
