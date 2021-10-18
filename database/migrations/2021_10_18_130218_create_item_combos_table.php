<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemCombosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_combos', function (Blueprint $table) {
            $table->id('item_combo_id');
            $table->foreignId('item_id')->references('item_id')->on('items')->cascadeOnDelete();
            $table->foreignId('combo_id')->references('combo_id')->on('combos')->cascadeOnDelete();
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
        Schema::dropIfExists('item_combos');
    }
}
