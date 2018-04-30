<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_food_items', function (Blueprint $table) {
            $table->increments('id');
            $table->text('cart_id');
            $table->integer('food_id');
            $table->integer('quantity');
            $table->tinyInteger('isOrdered')->comment('This is a boolean that shows whether an item was successfully ordered or not. Unordered item will be deleted');
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
        Schema::dropIfExists('cart_food_items');
    }
}
