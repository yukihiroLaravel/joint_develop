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

// Route::prefix('posts')->middleware('auth')->group(function () { //login機能が実装されたらこちらを有効化し、下を削除
Route::prefix('posts')->group(function () {
    // Route::get('{id}/edit', 'PostsController@edit')->name('posts.edit'); //西川さんが追加することを想定
    // Route::put('{id}', 'PostsController@update')->name('posts.update'); //西川さんが追加することを想定
    Route::delete('{id}', 'PostsController@destroy')->name('posts.delete');
});

Route::prefix('users')->group(function () {
    // ユーザ詳細
    Route::get('{id}', 'UsersController@show')->name('users.show');
    // ユーザ編集・更新
    Route::get('{id}/edit', 'UsersController@edit')->name('users.edit'); //->middleware('auth') login機能が実装されたら入れる
    Route::put('{id}', 'UsersController@update')->name('users.update'); //->middleware('auth') login機能が実装されたら入れる
});

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');


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
