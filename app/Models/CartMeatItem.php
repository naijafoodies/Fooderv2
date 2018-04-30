<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CartMeatItem extends Model
{
    public static function getCartItem($foodItemId) {

      return DB::table('cart_meat_items')
                ->where('cart_meat_items.cart_food_item_id','=',$foodItemId)
                ->join('meats','meats.id','=','cart_meat_items.meat_id')
                ->select('cart_meat_items.*','meats.name','meats.cost')
                ->get();
    }

    
}
