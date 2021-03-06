<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     21 April 2020
 */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('raw_data', 'CoronaApiController@getRawData');
Route::get('geo_data', 'CoronaApiController@getGeoJson');
Route::group(['prefix' => 'geo', 'namespace' => 'Geo'], function () {
    Route::get('state/search', 'GeoController@searchState')->middleware('cache.headers:public;max_age=1800');
    Route::get('city/search', 'GeoController@searchCity')->middleware('cache.headers:public;max_age=1800');
});

Route::group(['prefix' => 'otp', 'namespace' => 'Otp'], function () {
    Route::post('send', 'OtpVerificationController@send');
    Route::post('verify', 'OtpVerificationController@verify');
});

Route::group(['prefix' => 'plasma', 'namespace' => 'Plasma'], function () {
    Route::post('logout', 'PlasmaAccountController@logout');
    Route::post('delete', 'PlasmaAccountController@deleteRegistration');
    Route::post('registration/{request_id}', 'PlasmaAccountController@updateRegistration');

    Route::get('count', 'PlasmaApiController@getCount');
    Route::get('users', 'PlasmaApiController@getActiveUsers');
});
