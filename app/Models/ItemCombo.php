<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCombo extends Model
{
    use HasFactory;
    protected $primaryKey = 'item_combo_id';
    protected $fillable = [
        'combo_id',
        'item_id',
    ];
}
