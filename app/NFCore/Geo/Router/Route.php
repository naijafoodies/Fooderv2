<?php
/**
 * Created by PhpStorm.
 * User: Olusegun
 * Date: 4/15/2018
 * Time: 12:27 AM
 */

namespace App\NFCore\Geo\Router;

use App\NFCore\Geo\GeoDistance;
use GuzzleHttp\Client;


class Route
{
    protected $client;

    private $originExist = false;

    private $stopOverExists = false;

    private $destinationExists = false;

    private $apiTransactionSuccessful = false;

    private $origin;

    private $destination;

    private $stopOvers;

    private $totalMilesTravelled = 0;

    private $metersInMiles = 1609.34;

    public function __construct()
    {
        $this->client = new Client(['Timeout' => 400]);
    }

    public function setDestination($coordinates) {

        if($coordinates) {
            $this->destinationExists = true;
            $this->destination = urlencode($coordinates);
        }
    }

    public function setOrigin($coordinates) {

        if($coordinates) {
            $this->originExist = true;
            $this->origin = urlencode($coordinates);
        }

    }

    public function addStopOvers($stopOvers) {
        if($stopOvers) {
            $this->stopOverExists = true;
            $this->stopOvers = urlencode($stopOvers);
        }
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     * Function connects with the googleAPI to get the details of all the routes for the delivery
     */
    public function makeRoute() {

        $apiResponse = null;
        $developerAssets = new GeoDistance();

        if(!$this->originExist) {
            throw new \InvalidArgumentException("No Origin Exist");
        }

        if(!$this->destinationExists) {
            throw new \InvalidArgumentException("No Destination Exist");
        }

        if($this->stopOverExists) {
            $apiResponse = $this->client->request('GET','https://maps.googleapis.com/maps/api/directions/json?origin='.$this->origin.'&destination='.$this->destination.'&waypoints=optimize:true|'.$this->stopOvers.'&key='.$developerAssets->getDeveloperKey());
        }
        else {
            $apiResponse = $this->client->request('GET','https://maps.googleapis.com/maps/api/directions/json?origin='.$this->origin.'&destination='.$this->destination.'&key='.$developerAssets->getDeveloperKey());
        }

        $response = json_decode($apiResponse->getBody());

        if($response->status == 'OK') {
            $this->apiTransactionSuccessful = true;
            $this->processRoutes($response->routes[0]->legs);
        } else {
            throw new \Exception("Google responded with an error");
        }
    }

    private function processRoutes(array $totalLegsTravelled) {

        foreach($totalLegsTravelled AS $legs) {
            $this->totalMilesTravelled += $legs->distance->value;
        }

        return $totalLegsTravelled;
    }

    /**
     * @return float|int
     * @throws \Exception
     */
    public function getTotalMiles() {

        if($this->apiTransactionSuccessful) {
            return  number_format($this->totalMilesTravelled / $this->metersInMiles,2);
        }
        throw new \Exception("Routes have not been processed yet. Use class::makeRoute() before class::getTotalMiles");
    }
}