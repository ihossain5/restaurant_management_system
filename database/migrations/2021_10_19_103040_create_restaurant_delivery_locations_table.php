<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantDeliveryLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_delivery_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_location_id')->references('delivery_location_id')->on('delivery_locations')->cascadeOnDelete();
            $table->foreignId('restaurant_id')->references('restaurant_id')->on('restaurants')->cascadeOnDelete();
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
        Schema::dropIfExists('restaurant_delivery_locations');
    }
}
