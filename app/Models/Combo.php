<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    use HasFactory;
    protected $primaryKey = 'combo_id';
    protected $fillable = [
        'name',
        'price',
        'photo',
        'is_available',
        'restaurant_id',
    ];
    public function items() {
        return $this->belongsToMany(Item::class, 'item_combos','combo_id','item_id')->withTimestamps();
    }
    public function restaurant(){
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

}
