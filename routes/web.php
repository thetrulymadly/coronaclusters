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
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('', 'CoronaController@home')->middleware('cache.headers:public;max_age=1800;etag');
//Route::get('timeline', 'CoronaController@timeline');
//Route::get('{string?}/timeline', 'CoronaController@timeline')->where('string', '.*');
Route::get('corona-testing-per-day-india', 'CoronaController@testing')->middleware('cache.headers:public;max_age=1800;etag');

Route::group(['prefix' => 'plasma', 'namespace' => 'Plasma'], function () {
    Route::get('', 'PlasmaController@index');

    Route::get('donate', 'PlasmaDonorController@create');
    Route::post('donate', 'PlasmaDonorController@store');
    Route::get('donors', 'PlasmaDonorController@index');

    Route::get('request', 'PlasmaRequestController@create');
    Route::post('request', 'PlasmaRequestController@store');
    Route::get('requests', 'PlasmaRequestController@index');

    Route::get('requests/{request_id}', 'PlasmaController@donorDetail');
    Route::get('donors/{request_id}', 'PlasmaController@donorDetail');
});

// This should always be the last route in this file
Route::get('{string}', 'CoronaController@index')->where('string', '.*')->middleware('cache.headers:public;max_age=1800;etag');
