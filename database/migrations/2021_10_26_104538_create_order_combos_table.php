<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderCombosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_combos', function (Blueprint $table) {
            $table->id('order_combo_id');
            $table->foreignId('order_id')->references('order_id')->on('orders')->cascadeOnDelete();
            $table->foreignId('combo_id')->references('combo_id')->on('combos')->cascadeOnDelete();
            $table->integer('quantity');
            $table->double('price');
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
        Schema::dropIfExists('order_combos');
    }
}
