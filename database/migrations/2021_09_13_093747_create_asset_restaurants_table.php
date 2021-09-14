<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_restaurants', function (Blueprint $table) {
            $table->id('asset_restaurant_id');
            $table->foreignId('restaurant_id')->references('restaurant_id')->on('restaurants')->cascadeOnDelete();
            $table->foreignId('asset_type_id')->references('asset_type_id')->on('asset_types')->cascadeOnDelete();
            $table->string('asset');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_restaurants');
    }
}
