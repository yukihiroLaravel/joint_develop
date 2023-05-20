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

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ユーザ
Route::get('/', 'VerificationControllerr@index');
Route::prefix('users')->group(function () {
    Route::get('{id}', 'VerificationController@show')->name('user.show');
});

Route::get('/', function () {
    return view('welcome');
});