<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->foreignId('order_status_id')->references('order_status_id')->on('order_statuses');
            $table->foreignId('customer_id')->references('customer_id')->on('customers')->cascadeOnDelete();
            $table->foreignId('restaurant_id')->references('restaurant_id')->on('restaurants')->cascadeOnDelete();
            $table->string('id');
            $table->double('amount');
            $table->boolean('is_default_name')->default(0);
            $table->string('name')->nullable();
            $table->boolean('is_default_contact')->default(0);
            $table->string('contact')->nullable();
            $table->boolean('is_default_address')->default(0);
            $table->text('address')->nullable();
            $table->double('delivery_fee')->nullable();
            $table->text('apology_note')->nullable();
            $table->text('special_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('orders');
    }
}
