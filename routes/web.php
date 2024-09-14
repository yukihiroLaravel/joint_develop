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

// トップページの投稿表示
Route::get('/', 'PostsController@index');

// ユーザ新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// ユーザ
Route::group(['prefix' => 'users/{id}'],function(){

    // *******************
    // ユーザ詳細
    // *******************
    // タイムライン
    Route::get('', 'UsersController@show')->name('user.show');
    // フォロー中
    Route::get('followings','UsersController@followings')->name('user.followings');
    // フォロワー
    Route::get('followers','UsersController@followers')->name('user.followers');
    // *******************
});

// ログイン後
Route::group(['middleware' => 'auth'], function() {
    // 「ユーザ」
    Route::prefix('users')->group(function(){
        // 削除
        Route::delete('{id}', 'UsersController@destroy')->name('user.delete');
        //編集・更新
        Route::get('{id}/edit', 'UsersController@edit')->name('user.edit');
        Route::put('{id}', 'UsersController@update')->name('user.update');
    });
    
    // 「投稿」
    Route::prefix('posts')->group(function(){
        // 登録
        Route::post('', 'PostsController@store')->name('post.store');
        //削除
        Route::delete('{id}', 'PostsController@destroy')->name('post.delete');
    });

    // 「フォロー」
    Route::group(['prefix' => 'follows/{id}'],function(){
        Route::post('follow', 'FollowsController@store')->name('follow');
        Route::delete('unfollow', 'FollowsController@destroy')->name('unfollow');
    });
});

/* #region API */
/*
    本来はapiなのでapi.phpに追加すべきだがweb.phpに追加しました。
    
    ＜経緯＞
    api.phpでの「Route::middleware('auth:api')->」は、
    APIリクエストに対して、OAuthやJWT(JSON Web Token)などの仕組みを使って
    リクエストごとにそのトークンをヘッダーに付加する必要があります。

    API実装のみのバックエンド側で本格的にApiを使った開発であれば
    上記の基礎の仕組みからの準備や、リクエスト毎のセッション情報の永続化／復元などの仕組みなど、
    基礎実装をした上での開発だが、今回はそれは割愛し、webアプリ画面側でのログイン状態ならば、認証OKとする
    簡易的な対応としたいため、web.phpに追加し、
    Route::group(['middleware' => 'auth'], function() {
    での認証とすることにしました。
    言い換えると、webアプリ画面側の認証機能を間借りした対応としたいため、web.phpに追加しました。
    ( API実装のみのバックエンド側ではないため )
*/
Route::group(['middleware' => 'auth'], function() {
    Route::group(['prefix' => 'upload', 'namespace' => 'Api'], function () {

        // url=「/upload」のPOSTでアップロードで保存
        Route::post('', 'UploadController@store');
        
        /*
            url=「/upload/{id}」のPUTで更新

            idが何かはImageTypeによって異なる。
        */
        Route::put('{id}', 'UploadController@update');

        /*
            url=「/upload/{uuid}」のDELETEで削除

            uuidを指定するのは、sotrageからの削除を行うため
        */
        Route::delete('{uuid}', 'UploadController@destroy');
    });
});
/* #endregion */ // API
