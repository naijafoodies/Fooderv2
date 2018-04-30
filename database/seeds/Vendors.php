<?php

use Illuminate\Database\Seeder;

class Vendors extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('vendors')->insert([
          'name' => 'Eko Restaurant',
          'email' => 'olusegunakinyelure@gmail.com',
      ]);
    }
}
