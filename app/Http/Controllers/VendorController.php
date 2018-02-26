<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NFCore\Geo\GeoDistance;
use App\Models\Vendors;

class VendorController extends Controller
{
    public function getLocalVendors() {

      $distance = new GeoDistance('mile');
      $vendors = Vendors::all();

      $vendorsNearMe = null;

      foreach($vendors AS $vendor) {

        $distanceBetween = $distance->getDistance([
          'fromLatitude' => session('latitude'),
          'fromLongitude' => session('longitude'),
          'toLatitude' => $vendor->latitude,
          'toLongitude' => $vendor->longitude
        ]);

        if($distanceBetween >= 0 && $distanceBetween <= 31) {
          $vendor->distance = $distanceBetween;
          $vendorsNearMe[] = $vendor;
        }
      }

      return view('vendors.index',['vendors' => $vendorsNearMe]);

    }

}
