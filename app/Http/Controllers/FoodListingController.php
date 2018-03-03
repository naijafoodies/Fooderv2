<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FoodListingController extends Controller
{
    public function showByVendor(Request $request,$name,$id) {

      return view('foodlisting/listbyvendor')->with(['name'=>urldecode($name)]);

    }
}
