<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\FoodDescription;
use App\Models\FoodPicture;

class FoodController extends Controller {

  public function add(Request $request) {

    try {

      $food = new Food();
      $description = new FoodDescription();
      $picture = new FoodPicture();

      $food->vendor_id = $request->vendor_id;
      $food->food_name = $request->food_name;
      $food->food_cost = $request->food_cost;
      $food->save();

      $description->food_id = $food->id;
      $description->description = $request->description;
      $description->save();

      $picture->food_id = $food->id;
      $picture->file_name = $request->file('picture_file')->store('food/'.$request->vendor_id);
      $picture->save();

      return response()->json([
        'success' => true,
        'food_id' => $food->id
      ]);

    }
    catch(Exception $ex) {

      return response()->json([
        'success' => true,
        'Issue' => 'Server Error. Contact IT'
      ]);

    }

  }
}
