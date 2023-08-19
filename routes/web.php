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
Route::get('login', 'Auth\LoginController@showLoginForm')->name('loginform');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('users/{id}', 'UserController@showDetail')->name('users.show');
Route::get('users/{id}/edit', 'UserController@showEdit')->name('users.edit');
Route::post('update/user', 'UserController@updateUser')->name('users.update');
Route::post('users/delete/{id}', 'UserController@deleteUser')->name('users.delete');
Route::post('users/{id}/follow', 'FollowUserController@follow')->name('follow');
Route::post('users/{id}/unfollow', 'FollowUserController@unfollow')->name('unfollow');

// Route::get('/', function () {
//     return view('welcome');
// });
