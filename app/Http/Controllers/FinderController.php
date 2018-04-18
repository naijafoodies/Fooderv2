<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
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
    * throws Exception
    */
    foreach($vendors AS $vendor) {

        try {
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
        catch (GuzzleException $e) {
            return view('landing.index');
        }
        catch(\InvalidArgumentException $e) {
            return view('landing.index');
        }

    }

      return view('vendors.index')->with('matchingVendors',$matchingVendors);

  }


}
