<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaidSideItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_paid_side_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cart_food_item_id')->comment('The food this side is attached to. This is a foreign key connected to the cart food item table');
            $table->integer('side_id')->comment('This is the side connected to this. It is a foreign key on the side table');
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
        Schema::dropIfExists('cart_paid_side_items');
    }
}
