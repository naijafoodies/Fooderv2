<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Side;
use App\Models\VendorContract;
use App\Models\VendorFreeSide;

class SideController extends Controller
{
  public function add(Request $request) {

    try {

      $vendorContract = VendorContract::where('vendor_id',$request->vendor_id)->first();

      if($vendorContract->attaches_free_sides) {
        $side = new VendorFreeSide();
        $side->name = $request->name;
        $side->cost = 0.00;
        $side->vendor_id =  $request->vendor_id;
        $side->save();
      }
      else {
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
}
