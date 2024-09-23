<?php

namespace App\Helpers;

use App\UserImage;
use App\PostImage;
use Carbon\Carbon;

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

    /* #region 排他ロック */

    /**
     * 条件にマッチするときだけ排他ロックを取得してコールバックを実行する。
     */
    function doWithLockIfMatchCondition($lockName, callable $callback)
    {
        // 現在時刻
        $currentTime = Carbon::now('Asia/Tokyo');

        // メンテナンスタイムの開始、終了の設定値の取得
        $settingValueMaintenanceTimeStart = config('app.maintenanceTime.start');
        $settingValueMaintenanceTimeEnd = config('app.maintenanceTime.end');

        // メンテナンスタイムの開始、終了を取得
        $maintenanceStartTime = Carbon::createFromFormat('H:i', $settingValueMaintenanceTimeStart, 'Asia/Tokyo');
        $maintenanceEndTime = Carbon::createFromFormat('H:i', $settingValueMaintenanceTimeEnd, 'Asia/Tokyo');

        if ($currentTime->between($maintenanceStartTime, $maintenanceEndTime)) {
            // メンテナンスタイム内の場合、排他ロックを取得してコールバックを実行
            static::doWithLock($lockName, $callback);
        } else {
            // メンテナンスタイム外の場合、そのままコールバックを実行
            $callback();
        }
    }

    /**
     * $lockName毎の排他ロックを取得し$callbackを実行する。
     */
    function doWithLock($lockName, callable $callback)
    {
        /*
            fclose()自体はアトミックではなく、fclose()の内部処理でファイルクローズの途中で
            他のスレッドがfopen()を行うことが可能である。
            その場合は通常、ファイルハンドルは2つ以上は取得可能なため問題ないと言える。

            fopen()自体はロックとは関係がなく、実際にファイルロックを行うのは flock()である。

            flock() はPHPにおいてアトミックなロックが保証されており、
            複数のスレッドが同時に flock() を使ってロックを取得しようとした場合、
            一つのスレッドのみがロックを取得でき、他のスレッドは待ち状態となる。

            したがって、fopen()やfclose()がアトミックではなくとも、
            flock()によって、複数のスレッドが同時に$callback()を実行することはない。

            これにより、ロック処理の完全性を担保した。

            高負荷やリソース不足などで例外が発生する可能性はあるものの、
            「複数スレッドが同時に$callback()を実行しない」ことが
            doWithLock()の全体でみたときに、アトミックに担保されている実装となった。

            なお、PHPのThreaded::synchronizedは、CLI環境では意図した動作をするものの
            webアプリでは意図した動作をしない

            また、DB上にlocksのテーブルを定義する方法も検討したが、
            行ロックなどをしたときに、明示的なアンロックを意図したタイミングでするためには
            トランザクションを開始させて、commitするしかない
            そうすると、利用側の$callback();の内部処理までトランザクションの範囲
            となってしまう。これは使いにくい。

            このような諸事情があり、当実装に至った。
        */

        // ロックファイルのパス
        $lockFilePath = storage_path("app/public/{$lockName}.lock");

        $lockFile = fopen($lockFilePath, 'r+');

        if (!$lockFile) {
            // ロックファイルの環境準備が無い場合(または、準備はあるが、高負荷やリソース不足など)
            throw new \Exception("cannot open : {$lockFilePath}.");
        }

        try {
            // 排他ロック
            if (flock($lockFile, LOCK_EX)) {
                try {
                    // ロック取得時、コールバック実行
                    $callback();
                } finally {
                    // fclose()でロックも解放される。
                    fclose($lockFile);
                    $lockFile = null;
                }
            } else {
                // ロック取得失敗(または、高負荷やリソース不足など)
                throw new \Exception("cannot acquire lock: {$lockName}");
            }
        } catch (\Exception $e) {
            if ($lockFile) {
                fclose($lockFile);
                $lockFile = null;
            }
            throw $e;
        }
    }

    /* #endregion */ // 排他ロック

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
                アバター画像のためのアップロードUIコンポーネントは、「'multiFlg' => 'OFF'：単一画像モード」の時で、
                既に画像が1つ登録済状態の時は、「未指定のアップロードUI」はありえない。
                (  'imageType' => 'avatar' の時は、その想定。)

                後続処理の利便性を考慮し、filterFileInfoFromRequestなどでnull要素を取り除いてる
                コンテクストを想定している状況でもあり、

                「users」と「user_images」は「1対1」または「1対0」の関係であり、
                「user_images」へのDB反映を考える時、
                既に0件でないと判定されている状況においては、Mustで1件であることが要求される。

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
     * 「post_images」の再構成を行う。
     */
    public function reconstructionPostImage($post, $fileUuids, $fileNames)
    {
        /*
            $post->postImages()->delete();
            での一括削除は行わない。
            親：$user、子：$post、孫 : $post_image
            としたときに、ひ孫　のテーブルが、もし、将来的にできたときなど
            考慮し、確実に「孫 : $post_image」でのdeletingが発火する方式の
            布石としても、このほうが都合がよいだろう。
        */
        $postImages = $post->postImages()->get();

        // $postImagesの「DB値」を削除する
        static::deletePostImages($postImages);

        // $postImagesのinsertをする。
        static::insertPostImages($post->id, $fileUuids, $fileNames);
    }

    /**
     * $postImagesの「DB値」を削除する
     */
    public function deletePostImages($postImages)
    {
        if(is_null($postImages)) {
            return;
        }

        foreach($postImages as $postImage) {
            $postImage->delete();
        }
    }

    /**
     * $postImagesのinsertをする。
     */
    public function insertPostImages($postId, $fileUuids, $fileNames)
    {
        $requestFileInfoCount = static::getRequestFileInfoCountWithValidation($fileUuids, $fileNames);

        $order = 0;

        for($index = 0 ; $index < $requestFileInfoCount ; ++$index) {

            $uuid = $fileUuids[$index];
            $fileName = $fileNames[$index];

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
     * フォームのsubmitで送信されたfileUuidsおよびfileNamesの配列から、null値のエントリを取り除いたものを返す。
     */
    public function filterFileInfoFromRequest($request)
    {
        /*
            upload.jsで動的に作成したUI項目をformのsubmitでリクエストに乗せた場合
            「画像追加」ボタンに相当するもので、
            fileUuids、fileNamesが、ともに、null値で1要素入ってる。
            それがあった場合は取り除いた形のものを返す。

            この取り除く処理をどのタイミングで実行するかを検討すると、
            非GETのController側のメソッドのできるだけ早い段階でfileUuids、fileNames
            の値をリクエストより取得するときに、この調整をしておくほうが
            後続の処理が綺麗になると判断した。

            なお、
                ajaxのパラメータや、sessionStorageの読み書きではgetUploadUIInfo()でそれを取り除いている
                ここで言及しているのは、あくまで、「formのsubmitでリクエストに乗せた場合」の話だということをご留意願います。
        */
        $tempFileUuids = $request->input('fileUuids', []); // デフォルト空配列
        $tempFileNames = $request->input('fileNames', []); // デフォルト空配列

        $requestFileInfoCount = static::getRequestFileInfoCountWithValidation($tempFileUuids, $tempFileNames);

        $fileUuids = [];
        $fileNames = [];

        for ($index = 0 ; $index < $requestFileInfoCount ; ++$index) {
            $currentTempFileUuid = $tempFileUuids[$index];
            $currentTempFileName = $tempFileNames[$index];

            if(!$currentTempFileUuid || !$currentTempFileName) {
                continue;
            }

            $fileUuids[] = $currentTempFileUuid;
            $fileNames[] = $currentTempFileName;
        }

        $filteredFileInfo = [
            'fileUuids' => $fileUuids,
            'fileNames' => $fileNames,
        ];

        return $filteredFileInfo;
    }

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
