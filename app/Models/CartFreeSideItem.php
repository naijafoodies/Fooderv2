<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CartFreeSideItem extends Model
{
    public function __construct() {

    }

    public static function getCartItem($foodItemId) {

      return DB::table('cart_free_side_items')
                ->where('cart_free_side_items.cart_food_item_id','=',$foodItemId)
                ->join('vendor_free_sides','vendor_free_sides.id','=','cart_free_side_items.free_side_id')
                ->select('cart_free_side_items.*','vendor_free_sides.name','vendor_free_sides.cost')
                ->get();
    }

}
