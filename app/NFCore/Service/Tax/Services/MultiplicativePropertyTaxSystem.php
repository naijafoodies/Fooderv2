<?php
/**
 * Created by PhpStorm.
 * User: Olusegun
 * Date: 5/2/2018
 * Time: 10:13 PM
 *
 * Naijafoodies gives vendors the flexibility to use their custom tax percentage. In this case, the total tax of an order
 * cannot be quantified accurately. To get an average tax charged for a group of order items, a multiplicative property is being used.
 *  Please read the getTaxAmount() method to better understanding algorithm
 * NOTE : Naijafoodies does not charge TAX for delivery
 */

namespace App\NFCore\Service\Tax\Services;

use App\Models\VendorContract;
use App\NFCore\Service\Cart\CartService;
use App\NFCore\Service\Delivery\DeliveryLocationService;
use App\NFCore\Service\Tax\ITax;
use Illuminate\Support\Collection;
use App\NFCore\Support\Factories\Cart;

class MultiplicativePropertyTaxSystem implements ITax
{

    public function __construct()
    {

    }

    /**
     * @param string $cartId
     * @return \StdClass
     * Using a multiplicative
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTaxAmount(string $cartId)
    {
        $cartItems = CartService::getCartItem($cartId);

        $deliveryLocationService = new DeliveryLocationService($cartId);
        $orderDestination = $deliveryLocationService->getDestinationCoordinates(request());
        $deliveryCost = Cart::delivery($orderDestination->latitude,$orderDestination->longitude,$deliveryLocationService->getOrderVendorCoordinates());

        $cartSummary = new \StdClass;
        $taxCostObject = new \StdClass;
        $cartSummary->totalCostWithoutTax = 0;
        $cartSummary->totalCostWithTax = 0;
        $cartSummary->totalTaxCharged = 0;
        $cartSummary->deliveryCost = $deliveryCost->cost();

        /**
         * I will be looping through all the orders to compute the cost and set the vendors so that tax percentage can be added later
         */
        foreach($cartItems->foodItems AS $key=>$value) {
            $vendorId = $value->vendor_id;
            /**
             * To be able to seperate each vendors, I will be checking if the vendor is already created in the taxCost object.
             */
            if(isset($taxCostObject->$vendorId)) {
                $taxCostObject->$vendorId->cost += ($value->food_cost + self::calculateOtherCost($value->attachedPaidSides) + self::calculateOtherCost($value->attachedMeats)) * $value->quantity;
                $cartSummary->totalCostWithoutTax += $taxCostObject->$vendorId->cost;
            }
            else {
                $taxCostObject->$vendorId = new \StdClass;
                $taxCostObject->$vendorId->cost = ($value->food_cost + self::calculateOtherCost($value->attachedPaidSides) + self::calculateOtherCost($value->attachedMeats)) * $value->quantity;
                $cartSummary->totalCostWithoutTax += $taxCostObject->$vendorId->cost;
            }
        }

        /**
         * Upon seperating the cost for each vendor, the tax percentage as per vendor contract needs to be calculated. This might take up a lot of resources database resources
         * TODO NEEDS TO BE REFACTORED FOR EFFICIENCY
         */
        foreach($taxCostObject AS $vendorId => $value) {
            $vendorTaxRate = VendorContract::where("vendor_id",$vendorId)->first()["tax_rate"];
            $taxCostObject->$vendorId->vendorTaxPercentage = $vendorTaxRate;
            $taxCostObject->$vendorId->totalTaxCharged = $value->cost * ($vendorTaxRate/ 100);
            $cartSummary->totalTaxCharged += $value->cost * ($vendorTaxRate/ 100);
        }

        $cartSummary->grouped = $taxCostObject;
        $cartSummary->totalCostWithTax = $cartSummary->totalCostWithoutTax + $cartSummary->totalTaxCharged;

        return $cartSummary;
    }

    /**
     * @param Collection $costObject
     * @return int
     * Function calculates
     */
    public static function calculateOtherCost(Collection $costObject) {

        $totalCost = 0;

        foreach($costObject AS $key=>$value) {
            $totalCost += $value->cost;
        }

        return $totalCost;
    }
}