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
    // 新規登録画面表示
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
    // 新規登録実行
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// トップページの投稿表示のためコメントアウト
    // Route::get('/', 'UsersController@index');

    // ユーザ詳細
//Route::get('/', 'UsersController@index');
Route::get('/users/{id}',[App\Http\Controllers\UsersController::class,'show'])->name('users.show');
Route::prefix('users')->group(function () {
    Route::get('{id}', 'UsersController@show')->name('users.show');
});  

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// 投稿一覧表示
Route::get('/', 'PostsController@index')->name('posts');

// 投稿関連
Route::group(['middleware' => 'auth'], function () {
    // 投稿（新規、編集、更新、削除）
    Route::prefix('posts')->group(function () {
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
    });         
});
