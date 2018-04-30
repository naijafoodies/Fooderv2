<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorcontactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_contacts', function (Blueprint $table) {
            $table->increments('contact_id');
            $table->integer('vendor_id')->unique();
            $table->string('work_phone');
            $table->string('mobile_phone')->nullable();
            $table->string('fax')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_contacts');
    }
}
