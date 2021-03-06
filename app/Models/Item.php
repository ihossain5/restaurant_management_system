<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model {
    use HasFactory;
    protected $primaryKey = 'item_id';
    protected $fillable   = [
        'category_id',
        'name',
        'description',
        'price',
        'volume',
        'taste',
        'is_available',
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function item_assets() {
        return $this->belongsToMany(AssetType::class, 'asset_items', 'item_id', 'asset_type_id')->withPivot('asset_item_id', 'asset')->withTimestamps();
    }
    public function orders() {
        return $this->belongsToMany(Order::class, 'order_items', 'item_id', 'order_id')->withPivot('quantity', 'price')
            ->with('items', 'status', 'customer');
        // ->whereDate('created_at', '=', Carbon::now())
        // ->get();
    }

    public function completed_orders() {
        return $this->belongsToMany(Order::class, 'order_items', 'item_id', 'order_id')->withPivot('quantity', 'price')
            ->with('status', 'customer')
            ->whereMonth(
                'orders.created_at', '=', Carbon::now()->subMonth()->month
            )
            ->where('orders.order_status_id', 3);
        // ->whereDate('created_at', '=', Carbon::now())
        // ->get();
    }
    public function today_completed_orders() {
        return $this->belongsToMany(Order::class, 'order_items', 'item_id', 'order_id')->withPivot('quantity', 'price')
            ->with('status', 'customer')
            ->where('orders.order_status_id', 3)
            ->where('orders.restaurant_id', auth()->user()->restaurant->restaurant_id)
            ->whereDate('orders.created_at', '=', Carbon::now());
        // ->get();
    }

    public function completedOrdersByDate($start_date, $end_date) {
        return $this->belongsToMany(Order::class, 'order_items', 'item_id', 'order_id')->withPivot('quantity', 'price')
            ->with('status', 'customer')
            ->where('orders.order_status_id', 3)
            ->where('orders.restaurant_id', auth()->user()->restaurant->restaurant_id)
            ->whereDate('orders.created_at', '>=', $start_date)
            ->whereDate('orders.created_at', '<=', $end_date)
        ->get();
    }

    public function combos() {
        return $this->belongsToMany(Combo::class, 'item_combos', 'item_id', 'combo_id');
    }

    public static function findItemById($id) {
        $item = self::with('category', 'item_assets')->findOrFail($id);
        foreach ($item->item_assets as $asset) {
            $item->image = $asset->pivot->asset;
        }
        return $item;
    }
}
