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

Route::get('/', 'ParkingAppController@index');
Route::get('/admin', 'DashboardController@index');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/member/login', 'Auth\LoginController@login_member');
Route::get('/payment/{token?}', 'ParkingAppController@payment');
Route::get('/terms','ParkingAppController@terms');
Route::get('/privacy','ParkingAppController@privacy');
Route::get('/contact','ParkingAppController@contact');
Route::get('/paypal/success', 'ParkingAppController@paypal_success');
Route::get('/booking/destroy', 'ParkingAppController@booking_destroy');
Route::get('/forgot-password', 'ParkingAppController@forgot_password');
Route::get('/signup', 'ParkingAppController@signup');

Route::post('/member/authenticate', 'Auth\LoginController@login_member');
Route::post('/paypal', 'ParkingAppController@paypal');
Route::post('/payment', 'ParkingAppController@payment');
Route::post('/signup', 'ParkingAppController@save_signup');
Route::post('/booking/details/{id}/update', 'ParkingAppController@update_booking_details');
Route::post('/filter/search/{filter}', 'ParkingAppController@filter_result');
Route::post('/process/forgot-password', 'ParkingAppController@process_forgot_password');

Route::match(['get', 'post'], '/login', 'Auth\LoginController@login')->name('login');
Route::match(['get', 'post'], '/search', 'ParkingAppController@search');


Route::group(['prefix' => 'members'], function () {
	Route::get('/dashboard', 'MembersController@dashboard');
	Route::get('/profile', 'MembersController@display_profile');
	Route::post('/update/profile', 'MembersController@update_profile');
});

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
    Route::post('/booking/search', 'BookingsController@search');
    Route::post('/booking/update', 'BookingsController@update');
    Route::get('/customer/search', 'CustomersController@get_customer');

    Route::get('/get/price', 'PricesController@get_price');
    Route::get('/get/vehicle/model', 'BookingsController@get_vehicle_models');

    Route::post('/reports/booking/details/{id}', 'ReportsController@get_booking_details');
    Route::post('/reports/export', 'ReportsController@export');
    Route::match(['get', 'post'], '/reports/commissions', 'ReportsController@commissions');
    Route::match(['get', 'post'], '/reports/completed/jobs', 'ReportsController@completed_jobs');
    Route::match(['get', 'post'], '/reports/vendor/revenues', 'ReportsController@company_revenues');

    Route::resource('posts', 'PostsController')->except(['update', 'destroy', 'show']);
	Route::post('/posts/update', 'PostsController@update');

	Route::resource('fees', 'FeesController')->except(['update', 'destroy', 'show']);
	Route::post('/fees/update', 'FeesController@update');
	Route::post('/fees/{id}/delete', 'FeesController@delete');
});

Route::group(['prefix' => 'autocomplete'], function () {
    Route::post('/company', 'AutoCompleteController@company');
    Route::post('/product/revenue/share/{product_id}', 'AutoCompleteController@get_revenue_share');
});
