<?php

namespace App\Http\Controllers;

use App\NFCore\Service\Delivery\DeliveryLocationService;
use Illuminate\Http\Request;
use App\NFCore\Support\Factories\Cart;


class DeliveryController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCost() {

        $cart = new CartController();
        $cartId = $cart->getCartUniqueId($this->request);

        $deliveryLocationService = new DeliveryLocationService($cartId);

        $vendorCoordinates = $deliveryLocationService->getOrderVendorCoordinates();
        $destination = $deliveryLocationService->getDestinationCoordinates($this->request);

        return response()->json((float)Cart::delivery($destination->latitude,$destination->longitude,$vendorCoordinates)->cost());
    }

    public function getTotalDistance() {

    }

}
