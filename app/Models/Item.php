<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
    public function orders(){
        return $this->belongsToMany(Order::class,'order_items','item_id', 'order_id' )->withPivot('quantity','price')
        ->with('items', 'status','customer');
        // ->whereDate('created_at', '=', DB::raw('CURDATE()'))
        // ->get();
    }
    public function combos() {
        return $this->belongsToMany(Combo::class, 'item_combos','item_id','combo_id');
    }
    
    public static function findItemById($id){
        $item = self::with('category', 'item_assets')->findOrFail($id);
        foreach ($item->item_assets as $asset) {
            $item->image = $asset->pivot->asset;
        }
        return $item;
    }
}
