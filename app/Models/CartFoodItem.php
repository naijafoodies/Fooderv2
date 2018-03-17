<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CartFoodItem extends Model
{
    public function __construct() {

    }

    public static function getCartItem($cartId) {

      return DB::table('cart_food_items')
                ->where('cart_food_items.cart_id','=',$cartId)
                ->join('foods','cart_food_items.food_id','=','foods.id')
                ->join('vendors','foods.vendor_id','=','vendors.id')
                ->select('cart_food_items.*','foods.food_name','foods.food_cost','foods.vendor_id','vendors.name')
                ->get();

    }
}
