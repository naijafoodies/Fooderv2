<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


///////////
/// General Web Routes.
////////
Route::get('/','LandingController@showLanding');

Route::get('/mylocalrestaurants','FinderController@find');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/item/{id}','FoodListingController@showFoodDescription');

Auth::routes();


////////////
////  Vendor related API's
//////////
Route::group(array('prefix' => 'api/vendor/'), function() {

  Route::post('create','VendorController@enroll');
  Route::get('get/active','VendorController@getActiveVendors');
  Route::get('{id}/meat/get','MeatController@getByVendor');
  Route::get('{id}/sides/get','SideController@getByVendor');
});

/////////////
/// Vendor View Routes
///////////
Route::group(array('prefix' => 'vendor/'), function() {

  Route::get('{name}/{id}','FoodListingController@showByVendor');

});

////////////
/// Food API Group
///////////
Route::group(array('prefix' => 'api/food/'), function() {

  Route::post('add','FoodController@add');

});

//////////////
////  Meat Api
//////////////
Route::group(array('prefix' => 'api/meat/'), function() {

  Route::post('add','MeatController@add');

});


//////////////
////  Side API
///////////////
Route::group(array('prefix' => 'api/side/'), function() {

  Route::post('add','SideController@add');
});

Route::get('/api/create/location','LocationController@confirmAddress');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
