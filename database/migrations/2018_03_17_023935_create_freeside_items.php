<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreesideItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_free_side_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cart_food_item_id');
            $table->integer('free_side_id')->comment('This is a foreign key in the free sides table');
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
        Schema::dropIfExists('cart_free_side_items');
    }
}
