<?php


use Illuminate\Http\Request;

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

Route::group(['prefix' => 'movies', 'namespace' => 'Api'], function () {
    Route::get('', 'ApiController@index');
    Route::get('{id}', 'ApiController@show');
    Route::post('', 'ApiController@store');
    Route::put('{id}', 'ApiController@update');
    Route::delete('{id}', 'ApiController@destroy');
});