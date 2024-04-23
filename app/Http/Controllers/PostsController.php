<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post; //Postモデルを使用する為のインポート、投稿データを取得する為に使用
use App\User;//Userモデルを使用する為のインポート、ユーザーデータを取得する為に使用

class PostsController extends Controller
{
    public function index() //Postモデルから投稿情報を取得
    {
        //DB上の全投稿情報をid順で降順に並べ換える
        //->paginate(10)⇒1ページに10個のアイテムを表示するように指定
        $posts = Post::orderBy('id','desc')->paginate(10);
        
        //第一引数にはviewの名前を指定
        //第二引数にはviewに渡すデータを連想配列で指定し、「$posts」をviewの'welcome.blade.php'に投稿一覧を渡す記述
        return view('welcome', [
            'posts' => $posts,
        ]);
    }
}