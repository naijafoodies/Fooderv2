<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartMeatItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_meat_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cart_food_item_id')->comment('This is the food this meat is attached to');
            $table->integer('meat_id')->comment('This is a foreign key connected to the meat table');
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
        Schema::dropIfExists('cart_meat_items');
    }
}
