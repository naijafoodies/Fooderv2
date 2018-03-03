<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vendor extends Model {

  /**
  * Function retreives a vendor and all associated properties
  */
  public static function getAll() {

    return DB::table('vendors')
        ->join('vendor_contacts','vendors.id','=','vendor_contacts.vendor_id')
        ->join('vendor_contracts','vendors.id','=','vendor_contracts.vendor_id')
        ->join('vendor_addresses','vendors.id','=','vendor_addresses.vendor_id')
        ->join('vendor_descriptions','vendors.id','=','vendor_descriptions.vendor_id')
        ->join('vendor_emblems','vendors.id','=','vendor_emblems.vendor_id')
        ->select('vendors.*','vendor_contacts.*','vendor_contracts.*','vendor_addresses.*','vendor_descriptions.*','vendor_emblems.*')
        ->get();
  }

}
