<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeHeroSection extends Model
{
    use HasFactory;
    protected $primaryKey = 'home_hero_section_id';
    protected $fillable = ['heading','description','pic'];
}
