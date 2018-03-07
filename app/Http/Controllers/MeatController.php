<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meat;

class MeatController extends Controller
{
    public function add(Request $request) {

      try {

        $meat = new Meat();
        $meat->name = $request->name;
        $meat->cost = $request->cost;
        $meat->vendor_id =  $request->vendor_id;

        $meat->save();

        return response()->json([
          'success'=>true,
          'meat_id' => $meat->id
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
