<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NFCore\Geo\GeoDistance;

class VendorController extends Controller
{
    public function getLocalVendors() {

      $distance = new GeoDistance('mile');

      return $distance->getDrivingDistance([
        "toLatitude" => 39.832865,
        "toLongitude" => -86.160074,
        "fromLatitude" => 39.762591,
        "fromLongitude" => -86.160074
      ]);


    }

}
