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

// 投稿一覧(ログイン前)
Route::get('/', 'PostsController@index')->name('posts');

//検証用 あとで削除//////////////////////
// use Illuminate\Support\Facades\Auth;

// Route::get('/test-login/{id}', function ($id) {
//     Auth::loginUsingId($id);
//     return redirect('/');
// });
Route::get('/test-logout', function () {
    Auth::logout();
    return redirect('/');
});
