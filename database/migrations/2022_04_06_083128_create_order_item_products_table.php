<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_item_products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('order_item_id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('order_item_id')
            ->references('id')
            ->on('order_items')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('product_id')
            ->references('id')
            ->on('products')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_item_products');
    }
};
