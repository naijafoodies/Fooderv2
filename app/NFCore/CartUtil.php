<?php

  namespace App\NFCore;

  use App\Models\CartFoodItem;
  use Illuminate\Support\Facades\Session;

  class CartUtil
  {

    public function __construct() {

    }

    public static function getCartCount() {
      return count(CartFoodItem::where('cart_id',session('cartIdentifier'))->get());
    }
  }
