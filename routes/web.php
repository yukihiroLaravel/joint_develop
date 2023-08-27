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
Route::get('posts/{id}/edit', 'PostController@showEdit')->name('posts.edit');
Route::post('posts/{id}/update', 'PostController@updatePost')->name('posts.update');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('loginform');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
// ユーザ新規登録
Route::get('auth/register','Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('auth/register','Auth\RegisterController@register')->name('signup.post');
Route::get('users/{id}', 'UserController@showDetail')->name('users.show');
Route::get('users/{id}/edit', 'UserController@showEdit')->name('users.edit');
Route::post('update/user', 'UserController@updateUser')->name('users.update');
Route::post('users/delete/{id}', 'UserController@deleteUser')->name('users.delete');

// Route::get('/', function () {
//     return view('welcome');
// });
