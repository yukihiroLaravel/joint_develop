<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostsController;

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

// 投稿関連のルート
Route::get('/', [PostsController::class, 'index']);
Route::get('/post/create', [PostsController::class, 'create'])->name('post.create');

// ユーザ関連のルート
Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
