<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorAddress;
use App\NFCore\Geo\GeoDistance;
use App\Models\Vendor;

class FinderController extends Controller {

  protected $distanceEngine;

  public function __construct() {
    $this->distanceEngine  = new GeoDistance();
  }
  /**
  * Function finds vendors closer to customer latitude and longitude
  */
  public function find() {

    $vendors = Vendor::getAll();
    $matchingVendors = [];

    /**
    * I will be looping through an array of vendors here to get all vendors within 30 miles of the customer using
    * the geodistance algorithm for physical distance. WHile this algorithm does not consider driving distance, it
    * is more efficient to use now.
    * @todo Needs to sorted based on distance
    *
    */
    foreach($vendors AS $vendor) {

      $distance = $this->distanceEngine->getDrivingDistance([
        'fromLatitude' => session('latitude'),
        'fromLongitude' => session('longitude'),
        'toLatitude' => $vendor->latitude,
        'toLongitude' => $vendor->longitude
      ]);

      if($distance > 0 && $distance <= 35) {

          $matchingVendors[] = (object) [
            'id' => $vendor->id,
            'distance' => ceil($distance),
            'name' => $vendor->name,
            'address' => $vendor->address.', '.$vendor->city.', '.$vendor->state.' '.$vendor->zipcode,
            'fileName' => $vendor->file_name,
            'description' => $vendor->description
          ];
      }
    }

    return view('vendors.index')->with('matchingVendors',$matchingVendors);
  }


}
