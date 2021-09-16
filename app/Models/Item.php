<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $primaryKey = 'item_id';
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'volume',
        'taste',
        'is_available',
    ];

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function item_assets() {
        return $this->belongsToMany(AssetType::class, 'asset_items', 'item_id', 'asset_type_id')->withPivot('asset_item_id', 'asset')->withTimestamps();
    }
}
