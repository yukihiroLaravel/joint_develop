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

// ログイン・ログアウト
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ユーザ詳細
Route::prefix('users/{id}')->group(function () {
    Route::get('', 'UsersController@show')->name('users.show'); 
    // ユーザ情報編集
    Route::get('edit', 'UsersController@edit')->name('users.edit');
    // ユーザ情報更新
    Route::put('', 'UsersController@update')->name('users.update');
    // ユーザ削除
    Route::delete('', 'UsersController@destroy')->name('users.delete');
});
//トップページ
Route::get('/', 'PostsController@index'); 

// ログイン後
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('posts')->group(function () {
        // 新規投稿
        Route::post('', 'PostsController@store')->name('posts.store');
        // 投稿編集・更新
        Route::get('{id}/edit', 'PostsController@edit')->name('posts.edit');
        Route::put('{id}', 'PostsController@update')->name('posts.update');
        // 投稿削除
        Route::delete('{id}', 'PostsController@destroy')->name('posts.delete');
        // 投稿検索
        Route::get('search','PostsController@search')->name('posts.search');        
    });
});
