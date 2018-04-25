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

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/admin', function () {
//    return view('admin_template');
//});

Route::group(['prefix' => 'admin'], function () {
    Route::resource('airport', 'AirportsController')->except(['update', 'destroy', 'show']);
    Route::post('/airport/update', 'AirportsController@update');
    Route::post('/airport/{id}/delete', 'AirportsController@delete');
    Route::post('/airport/search', 'AirportsController@search');

    Route::resource('carpark', 'CarparkController')->except(['update', 'destroy', 'show']);
    Route::post('/carpark/update', 'CarparkController@update');
    Route::post('/carpark/{id}/delete', 'CarparkController@delete');
    Route::post('/carpark/search', 'CarparkController@search');

    Route::resource('product', 'ProductsController')->except(['update', 'destroy', 'show']);
    Route::post('/product/{id}/delete', 'ProductsController@delete');
    Route::post('/product/update', 'ProductsController@update');
});
