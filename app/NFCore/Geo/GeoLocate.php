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
  * The GeoLocate class is a location api that sits on top ot the guzzle client library to process address
  * based on numerous parameters. It is one of the core business module.
  *
  * Rules of Thumb to Developers
  * -------------------------------
  * Use camel casing for variable names
  * Code exist in app/NFCore/Geo namespace
  * Prefer dependency injection to reduce tight coupling
  */

  namespace App\NFCore\Geo;

  use GuzzleHttp\Client;

  class GeoLocate {

    protected $guzzle; // guzzle client
    protected $developerKey; // developer's key to google API

    private $isSuccessful = true;
    private $latitude;
    private $longitude;

    public function __construct($developerKey = ["key" => null]) {

      // Guzzle client instantiation is done here
      $this->guzzle = new Client([
        'timeout' => 400
      ]);

      $this->setDeveloperKey($developerKey);

    }


    /**
    * Function sets the key used by the google API. API key can be gotten @ https://console.developers.google.com
    *
    * @param $key
    * @return void
    */
    public function setDeveloperKey($key) {
      if($key['key']) {
        $this->developerKey = $key['key'];
      }
      else {
        $this->developerKey = "AIzaSyAHYH_rYFXt3r-NE-NU5MmIXEHgDRmUyQM"; // default naijafoodies google api key
      }
    }

    public function getDeveloperKey() {
      return $this->developerKey;
    }


    public function processAddress($address) {

      if(is_string($address)) {
        $this->getAddress($address);
      }
      else {
        $this->isSuccessful = false;
      }
    }

    public function getAddress($address) {

      $address = urlencode($address);
      $googleResponse = $this->guzzle->request('POST','https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.$this->developerKey);

      $response = json_decode($googleResponse->getBody());

      if($response->status === "OK") {

        $this->isSuccessful = true;

        $this->latitude = $response->results[0]->geometry->location->lat;
        $this->longitude = $response->results[0]->geometry->location->lng;
      }
      else {
        $this->isSuccessful = false;
      }
    }

    public function isSuccessful() {
      return $this->isSuccessful;
    }

    public function getLatitude() {
      return $this->latitude;
    }

    public function getLongitude() {
      return $this->longitude;
    }

    public function getGuzzleInstance() {
      return $this->guzzle;
    }


  }
