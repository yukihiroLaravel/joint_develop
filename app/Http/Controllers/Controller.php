<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 「$user」の投稿を取得する。
     */
    public function postsByUser($user)
    {
        // TODO ダミー実装だから後で本チャンの実装にすること

        // Postsのモデルクラスがきたら、後で置き換えること
        // Postsのモデルクラスがまだないため、ダミー実装

        // 本当は、
        // $movies = $user->movies()->orderBy('id', 'desc')->paginate(9);
        // のような感じのコードのはず

        // ********************************************************************
        // {!! nl2br(e($post->text)) !!}
        // で
        // ********************************************************************
        // たつのこ、たつお。だよん。<br />
        // <br />
        // おれのubuntu(WSL2)設定メモ<br />
        // で、ググってね<br />
        // <br />
        // よろしくね。。じゃ、またね。<br />
        // <br />
        // がちょーん
        // ********************************************************************
        // のイメージで画面表示できるかの、確認も
        // ダミー実装で、やってしまおう！！
        // ********************************************************************

        // ノーマルパターン(その１)
        $textNormalSono1 = <<<'EOD'
        たつのこ、たつお。だよん。
        
        おれのubuntu(WSL2)設定メモ
        で、ググってね
        
        よろしくね。。じゃ、またね。
        
        がちょーん。（その１）
        EOD;

        // ノーマルパターン(その２)
        $textNormalSono2 = <<<'EOD'
        たつのこ、たつお。だよん。
        
        おれのubuntu(WSL2)設定メモ
        で、ググってね
        
        よろしくね。。じゃ、またね。
        
        がちょーん。（その２）
        EOD;

        // イレギュラー
        // <br />タグを突っ込んどいて、エスケープされて<br />が画面にでるかの確認パターン。
        $textIrregular = <<<'EOD'
        たつのこ、たつお。だよん。<br />
        <br />
        おれのubuntu(WSL2)設定メモ<br />
        で、ググってね<br />
        <br />
        よろしくね。。じゃ、またね。<br />
        <br />
        がちょーん
        EOD;
        // ********************************************************************

        // 「created_at」について、$userのそれを突っ込むようなダミー実装で、表示の確認しとけば
        // おそらく、本チャンの実装にしても、うまくいくでしょう！！。
        $created_at = $user->created_at;

        $post = null;

        $isExistPost = true; // デバッガーで変更し、切り替える。
        if($isExistPost) {
            // ダミー実装
            $posts = [
                new PostDummy($user->id, $textNormalSono1, $created_at),
                new PostDummy($user->id, $textNormalSono2, $created_at),
                new PostDummy($user->id, $textIrregular, $created_at),
            ];
        } else {
            // 1件も、投稿してないユーザのケースの表示確認用
            $posts = [];
        }
        return $posts;
    }
}

// TODO ダミー実装です。
// postsByUser()を、本チャンのPostのモデルで実装した後で、消すこと！！
class PostDummy {
    public $user_id;  // ～.blade.phpでの「  @if (Auth::id() === $post->user_id)  」「削除」、「編集」ボタンの表示／非表示  用
    public $text;  // 項目名 textなのか不明だが。とりあえず、一旦。
    public $created_at;  // 投稿日時があったから。。

    public function __construct($user_id, $text, $created_at) {
        $this->user_id = $user_id;
        $this->text = $text;
        $this->created_at = $created_at;
    }
}
