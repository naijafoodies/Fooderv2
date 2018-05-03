<?php

namespace App\Http\Controllers;

use App\NFCore\Service\Cart\CartService;
use Illuminate\Http\Request;
use App\Models\CartFoodItem;
use App\Models\CartMeatItem;
use App\Models\CartFreeSideItem;
use App\Models\CartPaidSideItem;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function __construct() {

    }

    /**
     * @param Request $request
     * @return $this
     */
    public function showCart(Request $request) {

        $data['items'] = $this->getCartItem($request);

        return view('cart.cart')->with($data);
    }


    public function createCart() {
      $currentTime = date('his');
      $sesisonId = Session::getId();

      $cartIdentifier = encrypt($currentTime.''.$sesisonId);
      session(['cartIdentifier' => $cartIdentifier]);

      return $cartIdentifier;
    }

    public function addToCart(Request $request) {

      $foodCart = new CartFoodItem();

      // Will be saving food to the cart
      $foodCart->cart_id =  $this->getCartUniqueId($request);
      $foodCart->food_id = $request->foodId;
      $foodCart->quantity = $request->quantity;
      $foodCart->isOrdered = false;
      $foodCart->save();

      self::addMeatToCart($request->selectedMeat,$foodCart->id);
      self::addFreeSideToCart($request->selectedFreeSides, $foodCart->id);
      self::addPaidSideToCart($request->selectedPaidSides,$foodCart->id);

      if($foodCart->id) {
        return response()->json([
          'success' => true
        ]);
      }
      return response()->json([
        'success' => false
      ]);

    }

    public static function addMeatToCart($selectedMeat,$foodId) {
      $meatCollection = [];
      $selectedMeat = (!$selectedMeat) ? [] : $selectedMeat;

      for($i = 0; $i < count($selectedMeat); $i++) {

        array_push($meatCollection,[
            'cart_food_item_id' => $foodId,
            'meat_id' => $selectedMeat[$i],
            'created_at' => date('Y-m-d H:i:s')
        ]);
      }

      if($meatCollection) {
        CartMeatItem::insert($meatCollection);
      }
    }

    public static function addFreeSideToCart($selectedFreeSides,$foodId) {
      $selectedFreeSides = (!$selectedFreeSides) ? [] : $selectedFreeSides;
      /**
      * Instead of looping through the free sides, I will be creating an array of free sides to create a batch insert
      */
      $freeSidesCollection = [];
      for($i = 0; $i < count($selectedFreeSides); $i++) {

        array_push($freeSidesCollection,[
          'cart_food_item_id' => $foodId,
          'free_side_id' => $selectedFreeSides[$i],
          'created_at' => date('Y-m-d H:i:s')
        ]);

      }

      if($freeSidesCollection) {
        CartFreeSideItem::insert($freeSidesCollection);
      }
    }


    /**
     * Instead of looping through the free sides, I will be creating an array of free sides to create a batch insert
     * @param $selectedPaidSides
     * @param $foodId
     */
    public static function addPaidSideToCart($selectedPaidSides,$foodId) {
      $paidSidesCollection = [];
      $selectedPaidSides = (!$selectedPaidSides) ? [] : $selectedPaidSides;

      for($i = 0; $i < count($selectedPaidSides); $i++) {
        array_push($paidSidesCollection,[
          'cart_food_item_id' => $foodId,
          'side_id' => $selectedPaidSides[$i],
          'created_at' => date('Y-m-d H:i:s')
        ]);
      }

      if($paidSidesCollection) {
        CartPaidSideItem::insert($paidSidesCollection);
      }
    }

    public function getCartUniqueId($request) {
      if($this->cartExist($request)) {
        return session('cartIdentifier');
      }
      else {
        $this->createCart();
        return session('cartIdentifier');
      }
    }

    public function cartExist($request) {
      if ($request->session()->has('cartIdentifier')) {
        return true;
      }
      return false;
    }

    public function getCartItems() {

    }

    /**
     * @param Request $request
     * @param null $cartId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCartItem(Request $request,$cartId = null) {

      $cartId = ($cartId) ? $cartId : $this->getCartUniqueId($request);

      return response()->json(CartService::getCartItem($cartId));
    }
}
