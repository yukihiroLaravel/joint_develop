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


// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
// トップ投稿表示
Route::get('/', 'PostController@index')->name('post.list');

// ログイン・ログアウト
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ユーザ詳細
Route::get('users/{id}', 'UsersController@show')->name('user.show');

// リプライ
Route::group(['prefix' => 'posts/{id}'], function () {
    Route::get('', 'RepliesController@index')->name('reply.index');
    Route::post('reply', 'RepliesController@store')->name('reply.store');
});

//フォロー一覧
Route::get('users/{id}/followings', 'FollowController@showFollowings')->name('followings');
Route::get('users/{id}/followers', 'FollowController@showFollowers')->name('followers');

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('posts')->group(function () {
        Route::post('/','PostController@store')->name('posts.store');
        Route::get('{id}/edit', 'PostController@edit')->name('post.edit');
        Route::put('{id}', 'PostController@update')->name('post.update');
        Route::delete('{id}', 'PostController@destroy')->name('post.delete');
    });
    //フォロー
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'FollowController@follow')->name('follow');
        Route::post('unfollow', 'FollowController@unfollow')->name('unfollow');
    });
    // ユーザ退会
    Route::delete('users/{id}', 'UsersController@destroy')->name('user.delete');
    // リプライ編集・更新
    Route::prefix('reply/{id}')->group(function () {
        Route::put('', 'RepliesController@update')->name('reply.update');
        Route::delete('', 'RepliesController@destroy')->name('reply.delete');
    });
});
