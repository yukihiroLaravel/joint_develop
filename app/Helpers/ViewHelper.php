<?php

namespace App\Helpers;

use Thomaswelton\LaravelGravatar\Facades\Gravatar;
use App\Category;

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

    /* #region 「avatar.blade.php」関連 */

    /**
     * アバター画像のimgタグのstyle属性(まるごと)を取得する。
     */
    private function getAvatarImageStyle($isEdit, $imageSize)
    {
        /*
            resources/views/commons/avatar.blade.php
            でのアバター画像のimgのstyleについては、
            編集モードかどうかの違いは、" display:none;"の有無の違い
            でしかないため、一旦、変数に落として文字列連結に備える
        */
        $display = "";
        if($isEdit) {
            $display = " display:none;";
        }

        // アップロード済画像のimgタグ用のstyle値
        $imgUploadedAvatarStyle = trim("width:{$imageSize}px; height: {$imageSize}px;{$display}");
        $imgUploadedAvatarStyle = "style=\"{$imgUploadedAvatarStyle}\"";

        // Gravatar用の画像のimgタグ用のstyle値
        $imgGravatarStyle = trim($display);
        if( $imgGravatarStyle) {
            $imgGravatarStyle = "style=\"{$imgGravatarStyle}\"";
        } else {
            $imgGravatarStyle = "";
        }

        $avatarImageStyle = new \ArrayObject([
            "imgUploadedAvatarStyle" => $imgUploadedAvatarStyle,
            "imgGravatarStyle" => $imgGravatarStyle,
        ], \ArrayObject::ARRAY_AS_PROPS);

        return $avatarImageStyle;
    }

    /**
     * アバター画像のimgタグのid属性(まるごと)を取得する。
     *
     */
    private function getAvatarImageId($isEdit)
    {
        /*
            id属性が必要なのは、編集モードの時だけである。
            そうでない場合は、空文字列を指定しておく
        */
        $imgUploadedAvatarId = '';
        $imgGravatarId = '';
        if($isEdit) {
            $imgUploadedAvatarId = "id=\"imgUploadedAvatar\"";
            $imgGravatarId = "id=\"imgGravatar\"";
        }

        $avatarImageId = new \ArrayObject([
            "imgUploadedAvatarId" => $imgUploadedAvatarId,
            "imgGravatarId" => $imgGravatarId,
        ], \ArrayObject::ARRAY_AS_PROPS);
        
        return $avatarImageId;
    }

    /**
     * アバター画像のimgタグを作成する。
     */
    public function createAvatarImgTag($isEdit, $user, $imgSrcParam, $class, $imageSize)
    {
        /**
         * アバター画像のimgタグのstyle属性(まるごと)を取得する。
         * 
         * 「->」演算子でメンバーアクセス箇所での赤ニョロ回避の「PHPDoc」
         * @var object $avatarImageStyle
         * @property string $imgUploadedAvatarStyle
         * @property string $imgGravatarStyle
         */
        $avatarImageStyle = $this->getAvatarImageStyle($isEdit, $imageSize);
    
        /**
         * アバター画像のimgタグのid属性(まるごと)を取得する。
         * 
         * 「->」演算子でメンバーアクセス箇所での赤ニョロ回避の「PHPDoc」
         * @var object $avatarImageId
         * @property string $imgUploadedAvatarId
         * @property string $imgGravatarId
         */
        $avatarImageId = $this->getAvatarImageId($isEdit);
    
        /*
            (a) アップロードしたアバター画像がある場合 (言い換えると、テーブル「users」に1対1対応で紐づく「user_images」がある場合)
                「user_images」に基づいた画像を表示する。

            (b) アップロードしたアバター画像がない場合 (言い換えると、テーブル「users」に1対1対応で紐づく「user_images」がない場合)
                「Gravatar::src()」を用いた表示をする

            とした場合

            編集モードである時は、問答無用で(a)、(b)のimgタグを作っておいて、
                いずれも、style="display:none;" を指定して、一旦、消しておいて、
                javascript側で、いずれかをshow()する考え方とする。
                表示／非表示にかかわらず、(a)、(b)ともに、imgタグがDOMツリーにあったほうが
                javascript側の制御が楽である。
                編集モードの時は、１画面に１つしか当コンポーネントを配置しない想定なので
                1個に決め打ったid属性値を指定し、javascript側の制御しやすい形にしておく

            編集モードでない時は、
                style="display:none;" を指定する必要はなく
                条件に応じて、(a)のimgタグ、(b)のimgタグ のいずれか、一方を
                DOMツリーに置いておけばよい
    
                $imgSrcParamの値がある場合、
                    言い換えると
                    $imgSrcParamは、アップロード済の画像を表示するためのURLであり
                    その値がある場合とは、「「users」に1対1対応で紐づく「user_images」がある場合
                    なのであるが、
                    この場合は、
                    (a)のimgタグをDOMツリーに置く
                    (b)のimgタグはDOMツリーに置かない
                $imgSrcParamの値がない場合、
                    (a)のimgタグをDOMツリーに置かない
                    (b)のimgタグはDOMツリーに置く
    
                なぜなら、編集モードでない時は、
                表示専用のため画面表示時に一回、決まればよく、その後、javascript処理による表示変更は不要であるから。
                (a)のimgタグ、(b)のimgタグのうち、必要なものだけを一回、DOMツリーに置けばよいだけである。
        */

        // (a)のimgタグ imgUploadedAvatar をDOMツリーに置くかどうか
        $isDomImgUploadedAvatar = ( $isEdit || $imgSrcParam );

        // (b)のimgタグ imgUploadedAvatar をDOMツリーに置くかどうか
        $isDomImgGravatar = ( $isEdit || !$imgSrcParam );

        $imgUploadedAvatar = '';
        if ($isDomImgUploadedAvatar) {
            // (a)のimgタグ
            $imgUploadedAvatar =
                "<img {$avatarImageId->imgUploadedAvatarId} " .
                    "class=\"{$class}\" " .
                    "src=\"{$imgSrcParam}\" " .
                    "alt=\"{$user->name}\" " .
                    "{$avatarImageStyle->imgUploadedAvatarStyle}>"
            ;
        }

        $imgGravatar = '';
        if ($isDomImgGravatar) {
            $gravatarSrc = Gravatar::src($user->email, $imageSize);

            // (b)のimgタグ
            $imgGravatar =
                "<img {$avatarImageId->imgGravatarId} " .
                    "class=\"{$class}\" " .
                    "src=\"{$gravatarSrc}\" " .
                    "alt=\"{$user->name}\" " .
                    "{$avatarImageStyle->imgGravatarStyle}>"
            ;
        }

        $avatarImgTag = new \ArrayObject([
            "imgUploadedAvatar" => $imgUploadedAvatar,
            "imgGravatar" => $imgGravatar,
        ], \ArrayObject::ARRAY_AS_PROPS);
        
        return $avatarImgTag;
    }

    /* #endregion */ // 「avatar.blade.php」関連

    /**
     * トーストメッセージ用のjavascriptコードが実装されたscriptタグを取得する。
     * 
     * @param string $message メッセージ
     * @param string $alertClass アラートのクラス名(例:'success','danger')
     * @return string トーストメッセージ表示用のscriptタグ
     */
    public function getToastMessageScript($message, $alertClass)
    {
        // json_encodeしとくとjavascriptに指定しやすいとのこと
        $escapedMessage = json_encode(nl2br(e($message)));
        $escapedAlertClass = json_encode($alertClass);
        
        return "<script>showToast({$escapedMessage}, {$escapedAlertClass});</script>";
    }

    /**
     * $categoryIdについて、選択状態か判定し、'checked'か、空文字列を返却する。
     * カテゴリIDが選択されているかどうかを判定し、checked文字列を返す
     */
    public function getCurrentCategoryCheckedOrEmpty($categoryId, $initialSelectedCategories)
    {
        // 選択値
        $selectedCategories = old('categories', $initialSelectedCategories);

        $ret = '';
        if(in_array($categoryId, $selectedCategories)) {
            $ret = 'checked';
        }

        return $ret;
    }

    /**
     * 検索結果画面などに表示する検索条件の文字列を取得する。
     */
    public function getSearchConditionString($q, $c) {
        $ret = "";

        $joinString = "";
        if($q && $c) {
            $joinString = ", ";
        }

        if($q) {
            $ret .= "キーワード: " . $q;
        }

        $ret .= $joinString;

        if($c) {
            $categoryId = intval($c);
            $category = Category::findOrFail($categoryId);

            $ret .= "カテゴリ: " . $category->name;
        }

        return $ret;
    }

    /**
     * 検索結果がない時に表示する文字列を取得する。
     */
    public function getSearchNotFoundString() {
        $ret = '(´・ω・｀)見つかりませんでした。';
        return $ret;
    }

    /**
     * previousUrlのパラメータ指定値を取得する。
     */
    public function getPreviousUrlParameter()
    {
        $ret = [ 'previousUrl' => urlencode(\Request::fullUrl()) ];
        return $ret;
    }

    /**
     * 文字列中のurlを_blankのaタグに変換する。
     */
    function toLink($content)
    {
        $pat = '/((http|https):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/';
        $replace = '<a href="$1" target="_blank">$1</a>';
        $ret = preg_replace($pat, $replace, $content);
        return $ret;
    }
}
