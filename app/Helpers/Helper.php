<?php

namespace App\Helpers;

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

    /* #region postImages関連 */

    /**
     * $postImagesの「storage」と「DB値」を削除する
     */
    public function deletePostImages($postImages)
    {
        if(is_null($postImages)) {
            return;
        }

        foreach($postImages as $postImage) {
            $uuid = $postImage->uuid;
            // $imageType、$uuidを指定してstorageから削除
            static::deleteImageOnStorage('post', $uuid);

            $postImage->delete();
        }
    }

    /**
     * $postImagesのinsertをする。
     */
    public function insertPostImages($postId, $fileUuids, $fileNames)
    {
        if(empty($fileUuids) || empty($fileNames)) {
            return;
        }

        $fileUuidsLength = count($fileUuids);
        $fileNamesLength = count($fileNames);

        if($fileUuidsLength !== $fileNamesLength) {
            throw new \Exception(
                "fileUuidsLength : " . strval($fileUuidsLength) . 
                ", fileNamesLength : " . strval($fileNamesLength) .
                " not match.");
        }

        $order = 0;

        for($index = 0 ; $index < $fileUuidsLength ; ++$index) {

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
}
