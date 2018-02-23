<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NFCore\Geo\GeoLocate;

class LocationController extends Controller {

  public function __construct() {

  }

  /**
  * Function creates a location for client based on the address from the request
  */
  public function create(Request $request) {

    $geoLocator = new GeoLocate();

    $geoLocator->processAddress($request->address);

    /**
    * I will be creating a session array of User's geo coordinates
    */
    if($geoLocator->isSucessful()) {
      session([
        'latitude' => $geoLocator->getLatitude(),
        'longitude' => $geoLocator->getLongitude()
      ]);
    }

    /**
    *  WIll be returning the result of transactions
    */
      return response()->json([
        "successful" => $geoLocator->isSucessful()
      ]);

  }


}
