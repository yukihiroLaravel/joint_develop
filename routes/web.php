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
// トップページの表示
Route::get('/', 'PostsController@index');

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    // 動画
    Route::prefix('posts')->group(function () {
        Route::post('', 'PostsController@store')->name('post.store');
    });
    // 投稿 × タグ（解除）
    Route::delete('posts/{post}/tags/{tag}','PostTagController@destroy')->name('post.tag.destroy');
});

// ユーザ詳細・フォロー
Route::prefix('users')->group(function () {   
    Route::get('{id}', 'FollowController@timeline')->name('user.show');
    Route::get('{id}/followings', 'FollowController@followings')->name('user.followings');
    Route::get('{id}/followers', 'FollowController@followers')->name('user.followers');
    
    Route::post('{id}/follow', 'FollowController@follow')->name('user.follow');
    Route::delete('{id}/unfollow', 'FollowController@unfollow')->name('user.unfollow');

    Route::delete('{id}', 'PostsController@destroy')->name('user.delete');
});

// タグ一覧
Route::get('tags/{tag}', 'TagController@show')->name('tags.show');

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン、ログアウト
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');