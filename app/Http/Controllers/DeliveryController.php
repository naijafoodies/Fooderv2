<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NFCore\Support\Factories\Cart;
use App\Models\Food;
use App\Models\CartFoodItem;
use App\Models\VendorAddress;

class DeliveryController extends Controller
{
    public function __construct()
    {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCost(Request $request) {

        $cart = new CartController();
        $cartId = $cart->getCartUniqueId($request);

        $vendorCoordinates = self::getOrderVendorCoordinates($cartId);
        $deliveryCoordinates = self::getDeliveryCoordinates($request);

        return response()->json(Cart::delivery($deliveryCoordinates->latitude,$deliveryCoordinates->longitude,$vendorCoordinates)->cost());
    }

    public function getTotalDistance() {

    }

    /**
     * @param $cartId
     * @return array
     * Function returns an array of all the coordinates for each vendor of
     * every food inside a specific cart.
     */
    public static function getOrderVendorCoordinates($cartId) {

        $allFoodInCart = [];
        $allVendors = [];
        $coordinates = [];

        $foodInCart = CartFoodItem::where("cart_id",$cartId)->get();

        foreach($foodInCart as $food) {
            array_push($allFoodInCart,$food->food_id);
        }
        $food = Food::find($allFoodInCart);

        foreach($food as $vendor) {
            array_push($allVendors,$vendor->vendor_id);
        }
        array_unique($allVendors);

        $vendorAddresses = VendorAddress::find($allVendors);

        foreach($vendorAddresses as $address) {
            array_push($coordinates,[$address->latitude,$address->longitude]);
        }

        return $coordinates;
    }

    /**
     * @param Request $request
     * @return \StdClass
     */
    public static function getDeliveryCoordinates(Request $request) {

        $coordinates = new \StdClass;

        if($request->session()->has('latitude') && $request->session()->has('longitude')) {

            $coordinates->latitude = session('latitude');
            $coordinates->longitude = session('longitude');
        }

        return $coordinates;
    }
}
