<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model {
    use HasFactory;
    protected $primaryKey = 'order_id';
    protected $fillable   = [
        'customer_id',
        'order_status_id',
        'id',
        'amount',
        'is_default_name',
        'name',
        'is_default_contact',
        'contact',
        'is_default_address',
        'address',
        'delivery_fee',
        'apology_note',
        'special_notes',
    ];
    public function items() {
        return $this->belongsToMany(Item::class, 'order_items', 'order_id', 'item_id')->withPivot('quantity', 'price')->withTimestamps();
    }

    public function status() {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }
    public function customer() {
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function restaurant() {
        return $this->belongsTo(Restaurant::class,'restaurant_id');
    }

    public static function todayOrdersByRestaurantId($id) {
        return Restaurant::with(['restaurant_items.orders' => function ($query) {
            $query->whereDate('orders.created_at', DB::raw('CURDATE()'))->get();
        }])->find($id);

    }
}
