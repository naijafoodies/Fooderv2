<?php
/**
 * Created by PhpStorm.
 * User: Olusegun
 * Date: 5/2/2018
 * Time: 10:01 PM
 */

namespace App\NFCore\Service\Cart;


use App\Models\CartFoodItem;
use App\Models\CartFreeSideItem;
use App\Models\CartMeatItem;
use App\Models\CartPaidSideItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CartService
{

    /**
     * @var Request
     * Request interface
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $cartId
     * @return \StdClass
     * Function combines all the items added to a user cart. Multiple sides, meats and free sides are attached to one cart item. This method
     * combines all those attributes into one entity and merge them together as a key=>value pair
     */
    public static function getCartItem($cartId) {

        $cartItems = new \StdClass;

        $cartItems->foodItems = CartFoodItem::getCartItem($cartId);

        /**
         * I will be looping through the food to merge all paid sides, free sides and meat associated with the food item
         */
        foreach($cartItems->foodItems AS $key=>$value) {
            $cartItems->foodItems[$key]->attachedMeats = CartMeatItem::getCartItem($value->id);
            $cartItems->foodItems[$key]->attachedFreeSides = CartFreeSideItem::getCartItem($value->id);
            $cartItems->foodItems[$key]->attachedPaidSides = CartPaidSideItem::getCartItem($value->id);
        }

        return $cartItems;
    }

    /**
     * @return string
     * Function creates cart by encrypting current time and session id
     */
    public function create() {
        $currentTime = date('his');
        $sessionId = Session::getId();

        $cartIdentifier = encrypt($currentTime.''.$sessionId);
        session(['cartIdentifier' => $cartIdentifier]);

        return $cartIdentifier;
    }

    /**
     * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     * Function gets current cartId
     */
    public function getCartId() {
        if($this->cartExist()) {
            return session('cartIdentifier');
        }
        else {
            $this->create();
            return session('cartIdentifier');
        }
    }

    public function cartExist() {
        if ($this->request->session()->has('cartIdentifier')) {
            return true;
        }
        return false;
    }

}