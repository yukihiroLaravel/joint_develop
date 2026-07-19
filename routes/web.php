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

// 投稿一覧
Route::get('/', 'PostsController@index')->name('posts');

// ユーザ詳細
Route::get('users/{id}', 'UsersController@show')->name('users.show');

// ログイン後機能
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('posts')->group(function () {
        // 新規投稿
        Route::post('/', 'PostsController@store')->name('posts.store');
        // 投稿削除
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
        // 投稿編集画面表示
        Route::get('{id}/edit', 'PostsController@edit')->name('post.edit');
        // 投稿更新
        Route::put('{id}', 'PostsController@update')->name('post.update');
        // リアクション
        Route::post('{id}/reaction', 'ReactionsController@toggle')->name('reaction.toggle');
    });

    Route::prefix('users')->group(function () {
        // ユーザ編集・更新
        Route::get('{id}/edit', 'UsersController@edit')->name('users.edit');
        Route::put('{id}', 'UsersController@update')->name('users.update');
        // ユーザ退会
        Route::delete('{id}', 'UsersController@destroy')->name('users.destroy');
        // ユーザーのフォロー
        Route::post('{id}/follow', 'FollowController@store')->name('users.follow');
        // ユーザーのフォロー解除
        Route::delete('{id}/follow', 'FollowController@destroy')->name('users.unfollow');
    });
});

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ▼▼▼ テスト用（動作確認用の仮ログイン）コミット前に削除すること ▼▼▼
Route::get('/test-login/{id}', function ($id) {
    \Illuminate\Support\Facades\Auth::loginUsingId($id);
    return redirect('/');
});
Route::get('/test-logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/');
});
// ▲▲▲ テスト用ここまで ▲▲▲
