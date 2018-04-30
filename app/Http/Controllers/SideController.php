<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Side;
use App\Models\VendorContract;
use App\Models\VendorFreeSide;

class SideController extends Controller
{

  public function __construct() {

  }

  public function add(Request $request) {

    try {

      $vendorContract = VendorContract::where('vendor_id',$request->vendor_id)->first();

      if($vendorContract->attaches_free_sides) {

        // creating a free version of the sides
        $freeSides = new VendorFreeSide();
        $freeSides->name = $request->name;
        $freeSides->cost = 0.00;
        $freeSides->vendor_id =  $request->vendor_id;
        $freeSides->save();

        // Creating a paid version of the sides
        $side = new Side();
        $side->name = $request->name;
        $side->cost = $request->cost;
        $side->vendor_id =  $request->vendor_id;
        $side->save();
      }
      else {
        // Only creates a paid side for restaurtant
        $side = new Side();
        $side->name = $request->name;
        $side->cost = $request->cost;
        $side->vendor_id =  $request->vendor_id;
        $side->save();
      }

      return response()->json([
        'success'=>true,
      ]);
    }
    catch(Exception $ex) {

      return response()->json([
        'success'=>false,
        'meat_id' => 0
      ]);

    }
  }

  public function getByVendor($id) {

    $sides = new \stdClass;

    $sides->freeSides = VendorFreeSide::where('vendor_id',$id)->get();
    $sides->paidSides = Side::where('vendor_id',$id)->get();

    return response()->json($sides);
  }

}
