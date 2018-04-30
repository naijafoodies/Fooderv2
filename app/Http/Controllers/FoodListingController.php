<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Vendor;
use App\Models\FoodDescription;
use App\Models\FoodPicture;
use App\NFCore\Geo\GeoDistance;
use App\Models\VendorAddress;

class FoodListingController extends Controller
{
    public function showByVendor(Request $request,$name,$id) {

    	$data['vendorName'] = $name;
    	$data['foods'] = Food::getByVendor($id);

      	return view('foodlisting/listbyvendor',$data);

    }

    public function showFoodDescription(Request $request,$id) {

    	$distance = new GeoDistance('miles');


    	$food = Food::find($id);
    	$description = FoodDescription::where('food_id',$id)->first();
    	$picture = FoodPicture::where('food_id',$id)->first();
    	$vendor = Vendor::find($food->vendor_id);

    	$vendorAddress = VendorAddress::where('vendor_id',$food->vendor_id)->first();

    	$data['food'] = $food;
    	$data['description'] = $description->description;
    	$data['foodPicture'] = $picture->file_name;
    	$data['vendor'] = $vendor;

    	$data['distance'] = $distance->getDrivingDistance([
    		'fromLatitude' => (float)$vendorAddress->latitude,
    		'fromLongitude' => (float)$vendorAddress->longitude,
    		'toLatitude' => session('latitude'),
    		'toLongitude' => session('longitude')
    	]);
    	
    	return view('foodlisting/description',$data);
    }	

}
