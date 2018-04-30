<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Food extends Model {

	public static function getByVendor($id) {

		return DB::table('foods')

			->join('food_pictures','foods.id','=','food_pictures.food_id')
			->where('foods.vendor_id',$id)
			->select('foods.*','food_pictures.*')
			->get();
	}
   
}
