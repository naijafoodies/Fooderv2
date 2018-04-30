<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorUser extends Model {
  protected $connection = 'vendordb';
  protected $table = 'vendordb.users';
}
