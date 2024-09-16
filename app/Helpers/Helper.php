<?php

namespace App\Helpers;

use App\UserImage;
use App\PostImage;

/**
 * ヘルパークラス
 */
class Helper
{
    /*
        リクエスト毎のシングルトンであることに注意のこと。
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

    /* #region userImage関連 */

    /**
     * 「user_images」の再構成を行う。
     */
    public function reconstructionUserImage($user, $fileUuids, $fileNames)
    {
        $userImage = $user->userImage()->first();

        // 「user_images」のDELETE/INSERT処理を行う。

        /*
            DELETEの処理

            「users」と「user_images」は「1対1」または「1対0」の関係
            既にavatar画像がありの時を
            if ($userImage) {
            で判定し、そのときだけDELETEする。
        */
        if ($userImage) {
            $userImage->delete();
        }

        // $requestFileInfoCount関連

        $requestFileInfoCount = static::getRequestFileInfoCountWithValidation($fileUuids, $fileNames);
        if($requestFileInfoCount <= 0) {
            return;
        }

        if($requestFileInfoCount !== 1) {
            /*
                アップロードUIコンポーネントは、「'multiFlg' => 'OFF'：単一画像モード」の時で、
                既に画像が1つ登録済状態の時は、「未指定のアップロードUI」はありえない。
                (  'imageType' => 'avatar' の時は、その想定。)

                よって、前処理で 0件時をケアしている状況では、
                ここは、必ず、1でなければならない。

                アップロードUIコンポーネント側のバグ検知や、仕様変更時の対応漏れの発見
                の意味として、例外を投げる。
            */
            throw new \Exception(
                "requestFileInfoCount : " . strval($requestFileInfoCount) . " should be 1 . ");
            return;
        }

        // INSERTの処理

        $uuid = $fileUuids[0];
        $fileName = $fileNames[0];

        $userImage = new UserImage;
        $userImage->user_id = $user->id;

        $userImage->uuid = $uuid;
        $userImage->file_name = $fileName;

        $userImage->save();
    }
    
    /* #endregion */ // userImage関連


    /* #region postImages関連 */

    /**
     * $postImagesの「storage」と「DB値」を削除する
     */
    public function deletePostImages($postImages, $isNeedDeleteStorage = true)
    {
        if(is_null($postImages)) {
            return;
        }

        foreach($postImages as $postImage) {

            if ($isNeedDeleteStorage) {

                $uuid = $postImage->uuid;
                // $imageType、$uuidを指定してstorageから削除
                static::deleteImageOnStorage('post', $uuid);   
            }

            $postImage->delete();
        }
    }

    /**
     * $postImagesのinsertをする。
     */
    public function insertPostImages($postId, $fileUuids, $fileNames)
    {
        $requestFileInfoCount = static::getRequestFileInfoCountWithValidation($fileUuids, $fileNames);

        /*
            $requestFileInfoCountの値は、
            「if(is_null($uuid) || is_null($fileName)) {」
            が成立するケースも含んだ件数なので、後続処理を続行する。 
        */

        $order = 0;

        for($index = 0 ; $index < $requestFileInfoCount ; ++$index) {

            $uuid = $fileUuids[$index];
            $fileName = $fileNames[$index];

            if(is_null($uuid) || is_null($fileName)) {
                // ファイルが未指定のアップロードUIがあったりするのでその分は、スキップしたい
                continue;
            }

            $postImage = new PostImage;
            $postImage->post_id = $postId;
            $postImage->order = $order;

            ++$order;

            $postImage->uuid = $uuid;
            $postImage->file_name = $fileName;

            $postImage->save();
        }
    }

    /**
     *  $imageType、$uuidを指定してstorageから削除
     */
    public function deleteImageOnStorage($imageType, $uuid)
    {
        // storage/app/public　の配下の相対パス
        $folderRelativePath = "images/{$imageType}/{$uuid}";   

        /*
            config/filesystems.phpの'public'での定義しているフォルダの
            Illuminate\Filesystem\FilesystemAdapter のインスタンスを取得
        */
        $fsAdapterPublic = \Storage::disk('public');

        // フォルダが存在すれば削除
        if ($fsAdapterPublic->exists($folderRelativePath)) {
            // フォルダの削除「rm -r フォルダ」のイメージ
            $fsAdapterPublic->deleteDirectory($folderRelativePath);
        }
    }

    /* #endregion */ // postImages関連


    /* #region 「$fileUuids、$fileNames」関係のヘルパー処理 */

    /**
     * リクエストのファイル情報「$fileUuids、$fileNamesの件数取得」を行う。
     * その際、件数一致のアサーションもする。
     */
    public function getRequestFileInfoCountWithValidation($fileUuids, $fileNames)
    {
        if(empty($fileUuids) || empty($fileNames)) {
            return 0;
        }

        $fileUuidsLength = count($fileUuids);
        $fileNamesLength = count($fileNames);

        if($fileUuidsLength !== $fileNamesLength) {
            throw new \Exception(
                "fileUuidsLength : " . strval($fileUuidsLength) . 
                ", fileNamesLength : " . strval($fileNamesLength) .
                " not match.");
        }

        return $fileUuidsLength;
    }

    /**
     * 「編集モードの初期表示時のアップロードUIの復元情報」を作成する。
     */
    public function createUploadUiLoadInfo($fileUuids, $fileNames)
    {
        // 編集の初期表示時のアップロードUIの復元情報
        $loadInfo = new \ArrayObject([
            // uuid
            "fileUuids" => json_encode($fileUuids),
            // ファイル名
            "fileNames" => json_encode($fileNames),
        ], \ArrayObject::ARRAY_AS_PROPS);

        return $loadInfo;
    }

    /* #endregion */ // 「$fileUuids、$fileNamesの検証と件数取得」
}
