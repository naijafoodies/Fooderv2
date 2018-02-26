<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    protected $connection = "vendordb";
    protected $table = "vendordb.addresses";
}
