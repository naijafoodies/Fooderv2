<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CartPaidSideItem extends Model
{
  public static function getCartItem($foodItemId) {

    return DB::table('cart_paid_side_items')
              ->where('cart_paid_side_items.cart_food_item_id','=',$foodItemId)
              ->join('sides','sides.id','=','cart_paid_side_items.side_id')
              ->select('cart_paid_side_items.*','sides.name','sides.cost')
              ->get();
  }
}
