<?php

use App\Http\Controllers\PostsController;
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
// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

Route::get('/', 'PostsController@index');


//投稿表示
Route::get('/posts/welcome', [PostsController::class, 'index'])->name('posts.index');

Route::middleware('auth')->group(function(){

    //投稿表示
    Route::get('/posts/index', [PostsController::class, 'index'])->name('post.index');

    //ユーザ編集画面・更新
    Route::post('/posts/user/{id}', [PostsController::class, 'user'])->name('post.user');

    //投稿削除
    Route::get('/posts/delete/{id}', [PostsController::class, 'delete'])->name('post.delete');

});
//ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
