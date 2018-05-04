<?php
/**
 * Created by PhpStorm.
 * User: Olusegun
 * Date: 5/3/2018
 * Time: 11:26 PM
 */

namespace App\NFCore\Service\Delivery;


use App\Models\CartFoodItem;
use App\Models\Food;
use App\Models\VendorAddress;
use Illuminate\Http\Request;

class DeliveryLocationService
{
    protected $cartId;

    public function __construct(string $cartId)
    {
        $this->cartId = $cartId;
    }

    /**
     * @return array
     * Function returns an array of all the coordinates for each vendor of
     * every food inside a specific cart.
     */
    public function getOrderVendorCoordinates() {

        $allFoodInCart = [];
        $allVendors = [];
        $coordinates = [];

        $foodInCart = CartFoodItem::where("cart_id",$this->cartId)->get();

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
     * Function returns the origin of the order which is the customer address
     */
    public function getDestinationCoordinates(Request $request) {

        $coordinates = new \StdClass;

        if($request->session()->has('latitude') && $request->session()->has('longitude')) {
            $coordinates->latitude = session('latitude');
            $coordinates->longitude = session('longitude');
        }

        return $coordinates;
    }

}