<?php

namespace App\Helpers;

/**
 * ファイルの種類に関連する事柄を責務とするクラス
 */
class FileType
{
    /*
        ファイルの種類に関する知識を当クラスに集約し、
        各種アプリ内のコードに分散させたくない。
        ファイルの種類ごとの各種ハンドリングを当クラスの責務としたい。

        ★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        注意事項
        ★★★★★★★★★★★★★★★★★★★★★★★★★★★★
        しかし、フロントエンド間と、バックエンド間で分散してしまった。
        完全に同じ実装ではないが、関係する箇所は、
        public/js/common.js内部のFileTypeと同期をとったメンテナンスをすること！！
        ★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    */

    // 許可した画像の拡張子
    public const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif'];
    // 許可した動画の拡張子
    public const VIDEO_EXTENSIONS = ['mp4', 'webm', 'ogv', 'm4v'];
    // youTubeの拡張子(実際には存在しない拡張子だが、upload.jsにて、youtubeIdに、この拡張子を付与する形でファイル名を指定している)
    public const YOUTUBE_EXTENSIONS = ['youtube'];

    public $isImage;
    public $isVideo;
    public $isYoutube;
    public $isOther;

    public $isAvatar;
    public $isPost;
    public $isOtherType;

    /**
     * videoタグのtype属性に指定すべき値
     */
    public $typeValue = "";

    /**
     * YouTubeId
     */
    public $youtubeId = "";

    /**
     * ファイル名
     */
    private $fileName;

    /**
     * type「avatar,post」
     */
    private $type;

    public function __construct($argFileName, $argType)
    {
        $this->fileName = $argFileName;
        $this->type = $argType;

        $tempArray = null;

        // ファイルの拡張子を取得して小文字に変換
        $extension = strtolower(pathinfo($this->fileName, PATHINFO_EXTENSION));

        // 画像ファイルかどうか
        $this->isImage = in_array($extension, self::IMAGE_EXTENSIONS);

        // 動画ファイルかどうか
        $this->isVideo = in_array($extension, self::VIDEO_EXTENSIONS);
        if($this->isVideo) {
            if($extension === 'mp4') {
                $this->typeValue = 'video/mp4';
            }
            if($extension === 'webm') {
                $this->typeValue = 'video/webm';
            }
            if($extension === 'ogv') {
                $this->typeValue = 'video/ogg';
            }
            if($extension === 'm4v') {
                $this->typeValue = 'video/x-m4v';
            }
        }

        // youTubeかどうか
        $this->isYoutube = in_array($extension, self::YOUTUBE_EXTENSIONS);

        if($this->isYoutube) {
            $tempArray = explode(".", $this->fileName);
            $this->youtubeId = $tempArray[count($tempArray) - 2];
        }

        /*
            特記事項
            「 && !$this->isYoutube」の連結はあえて行わない

            バリデーションチェックなどに影響ある。
            $this->isYoutubeの時は、完全に別ロジック対応です。
            間違って、バリデーションチェックが動いても
            $this->isOtherのときと同じ、NGにしておきたい。

            おそらくないと思うが、.youtube の拡張子のテキストファイルなどを
            アップロードしてきたときに、誤動作にならいように、
            $this->isOtherとしてのバリデーションチェックが働く形としたい
            このような意図があり、
            「 && !$this->isYoutube」の連結はあえて行わない
        */
        // どちらにも該当しない場合
        $this->isOther = !$this->isImage && !$this->isVideo;

        // avatarかどうか
        $this->isAvatar = ($this->type === 'avatar');
        // postかどうか
        $this->isPost = ($this->type === 'post');

        // どちらにも該当しない場合
        $this->isOtherType = !$this->isAvatar && !$this->isPost;
    }

    /**
     *  画像や動画が格納されたフォルダの相対パスを
     *  storage/app/public　の配下の相対パスとして取得する。
     *  シンボリックリンクを通じての場合は、public/storageの配下
     */
    public function getFolderRelativePath($uuid)
    {
        $baseDirName = $this->getBaseDirName();

        // storage/app/public　の配下の相対パス
        $folderRelativePath = "{$baseDirName}/{$this->type}/{$uuid}";

        return $folderRelativePath;
    }

    /**
     * サムネイル画像としてのコンテクストで動画の場合は、同じuuidフォルダ内に、別で生成しているサムネイル画像名を返却する。
     * 上記以外は、純粋にファイル名を返却する。
     * このファイル名の返却を調整するのが当メソッドである。
     */
    public function adjustFileName($isThumbnailImg)
    {
        $this->checkInvalid("adjustFileName");

        if(!$isThumbnailImg) {
            /*
                サムネイル画像としてのコンテクストではない場合は、
                純粋にファイル名を返却すればよい
            */
            return $this->fileName;
        }

        /*
            サムネイル画像としてのコンテクストの場合は、
            動画の場合は、同じuuidフォルダ内に、別で生成しているサムネイル画像名を返却する。
        */

        if($this->isVideo) {
            return "thumbnail.jpg";
        }

        return $this->fileName;
    }

    /**
     * baseのディレクリ名を返す
     * 
     * storage/XXX/{type}/{uuid}/{fileName}
     * のパスのうち、XXXの部分に相当する
     */
    public function getBaseDirName()
    {
        $this->checkInvalid("getBaseDirName");

        if($this->isImage) {
            return "images";
        }
        if($this->isVideo) {
            return "videos";
        }

        // 本来、到達すべきでない制御パスに到達してしまった場合の例外対応
        $this->impossiblePattern("getBaseDirName");
    }

    /**
     * アップロードに関してバリデーションチェックをする(サーバーサイド)
     *
     * @param bool $isEnableVideo 動画のアップロードが可能なモードかどうか
     * @param int $uploadMaxFilesize 1ファイルあたりの最大アップロードサイズ(単位:MB)
     * @param int $uploadImageMaxFilesize 画像の場合の仕様で決めたアップロードの最大サイズ(単位:MB)
     * @param int $fileSize 今回、アップロードしようとしているファイルのサイズ(単位:バイト数)
     * @return string|null エラーメッセージ。nullの場合はバリデーション成功
     */
    public function validate($isEnableVideo, $uploadMaxFilesize, $uploadImageMaxFilesize, $fileSize)
    {
        $allowedExtensions = "";
        if ($isEnableVideo) {
            // 動画と画像両方の拡張子を連結してカンマ区切りにする
            $allowedExtensions = implode(', ', array_merge(self::IMAGE_EXTENSIONS, self::VIDEO_EXTENSIONS));
        } else {
            // 画像の拡張子のみをカンマ区切りにする
            $allowedExtensions = implode(', ', self::IMAGE_EXTENSIONS);
        }

        if ($this->isOther) {
            return "アップロード可能な「ファイル」は「{$allowedExtensions}」です。";
        }

        if (!$isEnableVideo) {
            // 動画のアップロードが許可されていない場合

            if($this->isVideo) {
                // 動画を指定した場合

                return "アップロード可能な「ファイル」は「{$allowedExtensions}」です。";
            }
        }

        if ($this->isVideo) {
            if ($fileSize > ($uploadMaxFilesize * 1024 * 1024)) {
                return "アップロード可能な「動画」は{$uploadMaxFilesize}MB以内です。";
            }
        }

        if ($this->isImage) {
            if ($fileSize > ($uploadImageMaxFilesize * 1024 * 1024)) {
                return "アップロード可能な「画像」は{$uploadImageMaxFilesize}MB以内です。";
            }
        }

        return null;
    }

    public function checkInvalid($methodName)
    {
        if($this->isOther || $this->isOtherType) {
            $this->invalidStateError($methodName);
        }

        if($this->isAvatar && $this->isVideo) {
            /*
                アバターで、かつ、動画の仕様はない。
                    周辺の利用コード側のアプリ実装にバグありの可能性が高いため、検知のため例外を投げる
                    ( デバッグを簡単にするのが目的 )
            */
            $this->invalidStateError($methodName);
        }
    }
    private function invalidStateError($methodName)
    {
        throw new \Exception(
            "不正な状態。\n" . 
            $this->dumpString($methodName)
        );
    }

    /**
     * 本来、到達すべきでない制御パスに到達してしまった場合の例外対応
     */
    private function impossiblePattern($methodName)
    {
        /*
            ＜＜elseを記述しないがために到達する制御パスで当メソッドにてハンドリングすることになった経緯の説明＞＞

            elseを書くと、周辺コードにバグがあるなどして、想定外の状況でelseに入るなどして
            周辺コードのバグを検知できないため、(結果デバッグが困難になるため)
            あえて、elseを書かない実装とした

            そのため、
            周辺コードにバグがあれば、ここに到達することになる。
            本来であれば、到達しないのは、承知の上である。
            
            「周辺コードにバグがあれば到達する」というのは、
            現時点のアプリの実装が単純だがら到達しないとわかりきってるから
            到達しないのではないか、今の実装でこんな仕掛けは不要ではないか

            などの考え方をするつもりは、一切ない。

            現時点が単純かどうかは関係ない。

            将来、複雑化した時も含めて、周辺コードにバグが入れ込まれた時は到達する

            そのレベルの思考で考えて実装している。

            当クラスは、
            ファイルの種類に関する知識を集約し、様々場所での利用を想定しているため
            条件を決め打って単純化するような実装をするつもりはない。

            "impossible pattern at xxxxxxxxx"
            という特別な値で、文字列ダンプした形で例外メッセージを作成し、
            周辺コードにバグがあったため、ここに到達したということが明示的にわかるようにしておく
        */
        $this->invalidStateError("impossible pattern at " . $methodName);
    }

    /**
     * メンバー値の状況を表す文字列を返す。
     * デバッグライトとしての利用を想定しpublicメソッドで定義する。
     */
    public function dumpString($argMethodName)
    {
        $methodName = "";
        if($argMethodName) {
            $methodName = $argMethodName;
        }

        $ret = 
            "************************************************\n" .
            "isImage[" . $this->isImage . "]\n" .
            "isVideo[" . $this->isVideo . "]\n" .
            "isOther[" . $this->isOther . "]\n" .
            "*********\n" .
            "isAvatar[" . $this->isAvatar . "]\n" .
            "isPost[" . $this->isPost . "]\n" .
            "isOtherType[" . $this->isOtherType . "]\n" .
            "*********\n" .
            "fileName[" . $this->fileName . "]\n" .
            "type[" . $this->type . "]\n" .
            "methodName[" . $methodName . "]\n" .
            "************************************************\n"
        ;
        return $ret;
    }
}
