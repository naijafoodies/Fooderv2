<?php
/**
 * Created by PhpStorm.
 * User: Olusegun
 * Date: 4/13/2018
 * Time: 1:16 AM
 */

namespace App\NFCore\Support\Factories;

use App\NFCore\Service\Delivery\DeliveryService;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;


class Cart
{
    protected static $id;

    public function __construct($id)
    {
        self::$id = $id;
    }

    /**
     * @param $destinationLatitude
     * @param $destinationLongitude
     * @param array|null $routes
     * @return DeliveryService
     * Function acts as a factory providing interfaces for the delivery service. This will allow client to
     * be able to make statements like Cart::delivery()->getTotalDistance, ->getCost
     */
    public static function delivery($destinationLatitude, $destinationLongitude, array $routes = null) {

        $deliveryOptions = new \StdClass;
        $deliveryOptions->cartId = self::$id;
        $deliveryOptions->destinationLatitude = $destinationLatitude;
        $deliveryOptions->destinationLongitude = $destinationLongitude;
        $deliveryOptions->routes = $routes;

        if($routes) {
            return new DeliveryService($deliveryOptions);
        }
        else {
            throw new MissingMandatoryParametersException("Must contain at least a route");
        }
    }
}