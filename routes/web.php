<?php

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

Route::get('/', 'PostController@showTop')->name('top');
Route::post('/', 'PostController@exePost')->name('post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::prefix('login')->group(function () {
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('loginform');
    Route::post('/', 'Auth\LoginController@login')->name('login');
});

Route::prefix('users')->group(function () {
    Route::prefix('{id}')->group(function () {
        Route::get('/', 'UserController@showDetail')->name('users.show'); 
        Route::get('edit', 'UserController@showEdit')->name('users.edit'); 
        Route::post('delete', 'UserController@deleteUser')->name('users.delete'); 
        Route::post('follow', 'FollowUserController@exeFollow')->name('follow'); 
        Route::post('unfollow', 'FollowUserController@exeUnfollow')->name('unfollow');
    });
    Route::post('update', 'UserController@updateUser')->name('users.update');
});

// ユーザ新規登録
Route::prefix('auth/register')->group(function () {
    Route::get('/','Auth\RegisterController@showRegistrationForm')->name('signup');
    Route::post('/','Auth\RegisterController@register')->name('signup.post');
});

// Route::get('/', function () {
//     return view('welcome');
// });
