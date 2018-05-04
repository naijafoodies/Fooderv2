<?php
/**
 * Created by PhpStorm.
 * User: Olusegun
 * Date: 4/11/2018
 * Time: 11:40 PM
 */

namespace App\NFCore\Service\Delivery;

use App\NFCore\Geo\Router\Route;
use App\NFCore\Utils\StringAppenders\Appender;
use App\NFCore\Utils\StringAppenders\Appenders\GroupedArray;
use App\NFCore\Utils\StringAppenders\Appenders\SingleArray;
use App\NFCore\Geo\GeoDistance;

class DeliveryService
{

    private $destinationLongitude;

    private $destinationLatitude;

    private $routes;

    private $feeAboveFiveMiles = 0.60;

    private $flatFee = 3.99;


    public function __construct(\StdClass $deliveryOptions)
    {
        $this->destinationLatitude = $deliveryOptions->destinationLatitude;
        $this->destinationLongitude = $deliveryOptions->destinationLongitude;
        $this->routes = (array) $deliveryOptions->routes;
    }

    /**
     * @return float|int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cost() {

        $totalMiles = $this->totalDistance();

        if($totalMiles <= 5) {
            $cost = $this->flatFee;
        }
        else {
            $cost = $totalMiles * $this->feeAboveFiveMiles;
        }

        $cost = number_format($cost,2);

        return (float) $cost;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     *
     */
    public function totalDistance() {

        $distance = new GeoDistance();

        /**
         * I will be setting all objects needed for api transactions here.
         */
        $location = new \StdClass;
        $location->origin = [$this->destinationLatitude,$this->destinationLongitude];
        $location->routes = $this->routes;

        $indexOfLocationWithLongestDistance = $distance->locationWithLongestDistance($location); // from a priority queue, this is the index of the route with the longest distance from the user set location

        /**
         * In order to get all the location needed for the google API, I will use the appender factory to
         * format the coordinates to mapable string
         */
        $tripOrigin = new Appender();
        $tripOrigin->append(new SingleArray($this->routes[$indexOfLocationWithLongestDistance]));

        /**
         * In order to set the trip origin, I will be removing the longest destination to user from the indexOfLocationWithLongestPriority above
         */
        unset($this->routes[$indexOfLocationWithLongestDistance]);
        $newRoutes = array_values($this->routes); // reindexing array after unset

        $stopOvers = new Appender();
        $stopOvers->append(new GroupedArray($newRoutes));

        $deliveryRoute = new Route();

        $deliveryRoute->setOrigin($tripOrigin->build());
        $deliveryRoute->setDestination($this->destinationLatitude.','.$this->destinationLongitude);
        $deliveryRoute->addStopOvers($stopOvers->build());
        $deliveryRoute->makeRoute();

        return $deliveryRoute->getTotalMiles();
    }

}