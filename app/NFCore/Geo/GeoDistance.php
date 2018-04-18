<?php

  /**
  * This file and all its dependencies is a product of Naija Foodies LLC. No unauthorized modification, rewrite or infringement allowed
  *
  * Developer(s)
  * - Olusegun Akinyelure
  *
  * NaijaFoodies 2018
  */

  /**
  * The GeoDistance class is a location api that helps calculates distances between two points using  a different of formulas based on the one
  * good for the job
  *
  * Rules of Thumb to Developers
  * -------------------------------
  * Use camel casing for variable names
  * Code exist in app/NFCore/Geo namespace
  * Prefer dependency injection to reduce tight coupling
  */

  namespace App\NFCore\Geo;

  use GuzzleHttp\Client;
  use Psr\Log\InvalidArgumentException;
  use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;

  class GeoDistance {

    private $earthRadius = 3959; // This is the earth radius in miles except otherwise changed to meters by developer
    private $measurementSystem = 'miles';

    private $guzzle; // instance of the guzzle api
    private $developerKey = 'AIzaSyAHYH_rYFXt3r-NE-NU5MmIXEHgDRmUyQM';

    private $isSuccessful = false;

    private $metersInMiles = 1609.34;

      /**
       * Core formula uses two coordinates. Mainly point A longitude, point A latitude and point B latitude, point B longitude
       * The standard of measurement must be passed to the constructor. Statedard of measurement is either miles or meters
       *
       * Formula only calculates physical distance. We will google API to get travel distance
       * @param null $standardOfMeasurement
       */
    public function __construct($standardOfMeasurement = null) {

      if($standardOfMeasurement === 'meters') {
        $this->earthRadius = 6371000;
        $this->measurementSystem = 'meters';
      }

      $this->guzzle = new Client(['timeout' => 400]);
    }

    public function getMeasurementSystem() {
      return $this->measurementSystem;
    }

    public function getDeveloperKey() {
      return $this->developerKey;
    }

    public function setDeveloperKey($key) {
      if(is_string($key)) {
        $this->developerKey = $key;
      }
    }


      /**
       * Function calculates the distances between the coordinates passed to it usign the Vincenty formula. The Haversine formula seems to
       * be incorrect for long distances
       *
       * @param array $coordinates
       * @return float physical address
       * @internal param $coordinates - needs four keys fromLatitude,toLatitude,fromLongitude,toLongitude
       */
    public function getDistance($coordinates = array()) {

      self::checkCoordinates($coordinates);

      $coordinates['fromLatitude'] = deg2rad($coordinates['fromLatitude']);
      $coordinates['toLatitude'] = deg2rad($coordinates['toLatitude']);
      $coordinates['fromLongitude'] = deg2rad($coordinates['fromLongitude']);
      $coordinates['toLongitude'] = deg2rad($coordinates['toLongitude']);

      $longitudeDelta = $coordinates['toLongitude'] - $coordinates['fromLongitude'];

      $angleA = pow(cos($coordinates['toLatitude']) * sin($longitudeDelta),2) + pow(cos($coordinates['fromLatitude']) * sin($coordinates['toLatitude']) - sin($coordinates['fromLatitude']) * cos($coordinates['toLatitude']) * cos($longitudeDelta),2);
      $angleB = sin($coordinates['fromLatitude']) * sin($coordinates['toLatitude']) + cos($coordinates['fromLatitude']) * cos($coordinates['toLatitude']) * cos($longitudeDelta);

      $mainAngle = atan2(sqrt($angleA),$angleB);
      return $mainAngle * $this->earthRadius;
    }


      /**
       * Function provides the driving distance between two locations using google api and depending on the guzzle client
       *
       * @param array
       * @return float
       * @throws \GuzzleHttp\Exception\GuzzleException
       */
    public function getDrivingDistance($coordinates = array()) {

      self::checkCoordinates($coordinates);
      $distance = $this->processDistanceApi($coordinates);

      // API returns distance in meters. I will be converting to miles
      return $distance / $this->metersInMiles;
    }

      /**
       * Makes a google request to get distances between two places using guzzle
       * @param $coordinates
       * @return int
       * @throws \GuzzleHttp\Exception\GuzzleException
       */
    private function processDistanceApi($coordinates) {

      $googleResponse = $this->guzzle->request('POST','https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$coordinates['fromLatitude'].','.$coordinates['fromLongitude'].'&destinations='.$coordinates['toLatitude'].','.$coordinates['toLongitude'].'&mode=driving&language=pl-PL&key='.$this->getDeveloperKey());

      $response = json_decode($googleResponse->getBody());

      if($response->status === "OK") {
        $this->isSuccessful = true;
        return $response->rows[0]->elements[0]->distance->value;
      }

      return 0;

    }


      /**
       * Function verifies if @param has all the required keys to perform distance operation. it also checks is the values are valid
       *
       * @return bool
       */
    public static function checkCoordinates($coordinates) {

      if(self::hasToLatitude($coordinates) && self::hasFromLatitude($coordinates) && self::hasToLongitude($coordinates) && self::hasFromLongitude($coordinates)) {

        if(self::isLatitude($coordinates['fromLatitude']) && self::isLatitude($coordinates['toLatitude']) && self::isLongitude($coordinates['toLongitude']) && self::isLongitude($coordinates['fromLatitude'])) {
          return true;
        }
        else {
          throw new InvalidArgumentException("One of many of the points does not meet requirements for geo coordinate eveluation ");
        }
      }

      throw new \InvalidArgumentException("Coordinates must include a toLatitude, fromLatitude, toLongitude, fromLongitude");
    }

    /**
    * @param coordinates
    * @return boolean
    */
    public static function hasFromLatitude($coordinates) {
      return isset($coordinates['fromLatitude']);
    }

    /**
    * @param coordinates
    * @return boolean
    */
    public static function hasToLatitude($coordinates) {
      return isset($coordinates['toLatitude']);
    }

    /**
    * @param coordinates
    * @return boolean
    */
    public static function hasFromLongitude($coordinates) {
      return isset($coordinates['fromLongitude']);
    }

    /**
    * @param coordinates
    * @return boolean
    */
    public static function hasToLongitude($coordinates) {
      return isset($coordinates['toLongitude']);
    }

    public static function isLatitude($latitude) {
      $validLatitude = false;

      if(is_float($latitude)) {
        $validLatitude = true;
      }

      if($latitude >= -90 && $latitude <= 90) {
        $validLatitude = true;
      }

      return $validLatitude;
    }


    public static function isLongitude($longitude) {
      $validLongitude = false;

      if(is_float($longitude)) {
        $validLongitude = true;
      }

      if($longitude >= -180 && $longitude <= 180) {
        $validLongitude = true;
      }

      return $validLongitude;
    }

      /**
       * @param array|\StdClass $locations
       * Function checks through an array of locations to determine the one with the longest distances between the
       * origin and each of the location. I will be using a priority queue to avoid writing an algo for this.
       *
       * The origin is an array consisting of latitude and longitude
       * The origin consists of arrays of latitude and longitudes of all destination
       * @return mixed
       * @throws \GuzzleHttp\Exception\GuzzleException
       */
    public function locationWithLongestDistance(\StdClass $locations) {

        if(!isset($locations->origin) || !isset($locations->routes)) {
            throw new MissingMandatoryParametersException("Location needs an origin or route");
        }

        $queuedLocations = new \SplPriorityQueue;

        foreach($locations->routes as $key=>$destination) {

            /**
             * I will be getting the driving distance in miles from here
             */
            $drivingDistance = $this->getDrivingDistance([
                'fromLatitude' => $locations->origin[0],
                'fromLongitude' => $locations->origin[1],
                'toLatitude' => $destination[0],
                'toLongitude' => $destination[1]
            ]);

            $locationKey = new \StdClass;
            $locationKey->position = $key;
            $queuedLocations->insert($locationKey,round($drivingDistance));
        }

        $queuedLocations->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
        $indexOfTopPriority = $queuedLocations->top();
        return $indexOfTopPriority['data']->position;
    }

  }
