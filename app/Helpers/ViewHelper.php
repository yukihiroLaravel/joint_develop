<?php

namespace App\Helpers;

/**
 * viewの処理のヘルパークラス
 */
class ViewHelper extends Helper
{
    /*
        汎化できるようにシングルトンで定義したが、
        現状は、リクエスト毎のシングルトンであることに注意のこと。
        インクルードの構造が深く途中でループ処理もあるような時
        当クラスのインスタンスが多数、作られメモリを圧迫したくない。
        そのためシングルトンの実装をしたが、一般的な実装をすると、
        php言語特性や動作環境の特性で、リクエスト毎シングルトンとなるが、
        一旦はそれでよいと判断した。
        多言語に見られるAPサーバー起動中の1インスタンスではない。
        そうするやり方はあるようだが、現状は、そこまでは不要なのでしていない。
        リクエストをまたいだ制御や、情報の引き継ぎなどで必要になったときに考慮すればよい。
        おそらく、その場合でも利用している側には影響させずに、当クラス内の実装で
        吸収できそうに思えるため、現状は、このままでよいとした。
    */
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * 「$followsParam」を作成する。
     */
    public function createFollowsParam($user) {
        /*
            デフォルト値を求める。
            そもそも、仕様として、フォロー機能が不要な
            画面表示箇所がある場合(将来も含め)
            は、当メソッドではなく
            $followsParam = \App\User::createDefaultFollowsParam();
            の形でデフォルト値だけで後続処理を進めればよい
        */
        $followsParam = \App\User::createDefaultFollowsParam();

        /*
            結果的に、isFollowsBaseOk、がtrue時は、常に、$user->idは、
            ログインユーザ以外なので、$otherUserIdの変数名としておく

            当メソッドはデフォルト値に対して、
            「Auth::id()」と「$otherUserId」の状況に従って、$followsParamを更新する
            ために、updateFollowsParam()を実行する
        */
        $otherUserId = $user->id;
        \App\User::updateFollowsParam($followsParam, $otherUserId);

        return $followsParam;
    }

    /**
     * フォローボタン「resources/views/follows/button.blade.php」に関する設定情報を取得する。
     */
    public function getFollowButtonConfig($followsParam) {
        /*
            ＜パターン1＞
            「フォロー中」である
            「フォロワー」である
            上記、AND条件が成立するケース
        */
        $isControlPattern1 = ($followsParam->isFollowings && $followsParam->isFollowers);

        /*
            ＜パターン2＞
            「フォロー中」である
            「フォロワー」でない
        */
        $isControlPattern2 = ($followsParam->isFollowings && !$followsParam->isFollowers);

        /*
            ＜パターン3＞
            「フォロー中」でない
            「フォロワー」である
            上記、AND条件が成立するケース
        */
        $isControlPattern3 = (!$followsParam->isFollowings && $followsParam->isFollowers);

        /*
            ＜パターン4＞
            「フォロー中」でない
            「フォロワー」でない
            上記、AND条件が成立するケース
        */
        $isControlPattern4 = (!$followsParam->isFollowings && !$followsParam->isFollowers);

        /*
            「form」タグは、デフォルトではブロック要素で、改行されて、下の段となってしまうため
            それを防ぎたい。また、中身のフォロー系のボタンを強制的に右寄せしたい。

            これを実現するため試行錯誤した結果、下記の値をstyleに指定すればよいと判明した。
            エスケープされないように、{!! $config->formTagStyle !!} の形で指定する。

            当実装は仕様の変化に応じて、多目的な画面位置にインクルードされうるため、
            その場所に応じたレイアウト調整が行いやすいように、
            一旦、変数に値を詰め込み、当ロジックでの条件分岐で吸収可能な状況としたい。
        */
        $formTagStyle = 'style="overflow: hidden; float: right; display: inline;"';

        // パターンに応じてactionの値を決定する。
        $actionValue = null;
        if ($isControlPattern1 || $isControlPattern2) {
            $actionValue = route('unfollow', $followsParam->otherUserId);
        }
        if ($isControlPattern3 || $isControlPattern4) {
            $actionValue = route('follow', $followsParam->otherUserId);
        }

        $config = new \ArrayObject([
            "isFollowButtonVisible" => ($isControlPattern1 || $isControlPattern2 || $isControlPattern3 || $isControlPattern4),

            "isControlPattern1" => $isControlPattern1,
            "isControlPattern2" => $isControlPattern2,
            "isControlPattern3" => $isControlPattern3,
            "isControlPattern4" => $isControlPattern4,

            "actionValue" => $actionValue,
            "formTagStyle" => $formTagStyle,
        ], \ArrayObject::ARRAY_AS_PROPS);

        return $config;
    }
}
