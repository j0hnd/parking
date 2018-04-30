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

Route::get('/admin', 'DashboardController@index');
Route::get('/', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::match(['get', 'post'], '/login', 'Auth\LoginController@login')->name('login');


Route::group(['prefix' => 'admin'], function () {
    Route::get('/dashboard', 'DashboardController@index');

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

    Route::resource('users', 'UsersController')->except(['update', 'destroy', 'show']);
    Route::get('/users/profile', 'UsersController@profile');
    Route::post('/users/search', 'UsersController@search');
    Route::post('/users/update', 'UsersController@update');
    Route::post('/users/{id}/delete', 'UsersController@delete');
    Route::post('/users/{id}/reset', 'UsersController@reset');

    Route::resource('booking', 'BookingsController')->except(['update', 'destroy', 'show']);
    Route::get('/customer/search', 'CustomersController@get_customer');
    Route::post('/booking/update', 'BookingsController@update');

    Route::get('/get/price', 'PricesController@get_price');
    Route::get('/get/vehicle/model', 'BookingsController@get_vehicle_models');
});
