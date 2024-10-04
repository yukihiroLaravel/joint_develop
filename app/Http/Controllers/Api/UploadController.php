<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UnusedFileChecker;
use App\Helpers\FileType;
use App\Helpers\Helper;

class UploadController extends Controller
{
    /**
     * 'imageType'のバリデーションの指定値
     * (avatar または post のみ許可)
     */
    private const IMAGE_TYPE_VALIDATION = 'required|string|in:avatar,post';

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'imageType' => self::IMAGE_TYPE_VALIDATION,
        ]);

        $helper = Helper::getInstance();

        $imageType = $request->imageType;

        // 動画のアップロードが可能なモードかどうか
        $enableVideoFlg = $request->enableVideoFlg;
        $isEnableVideo = ($enableVideoFlg === 'ON');

        // ファイル取得
        $file = $request->file('file');

        // uuidの作成
        $uuid = \Str::uuid();

        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();

        $fileType = new FileType($fileName, $imageType);

        // 1ファイルあたりの最大アップロードサイズ(単位:MB)
        $uploadMaxFilesize = intval(config('app.uploadMaxFilesize'));

        // 画像の場合の仕様で決めたアップロードの最大サイズ(単位:MB)
        $uploadImageMaxFilesize = intval(config('app.uploadImageMaxFilesize'));

        // アップロードに関してバリデーションチェックをする(サーバーサイド)
        $validateRet = $fileType->validate(
            // 動画のアップロードが可能なモードかどうか
            $isEnableVideo,
            // 1ファイルあたりの最大アップロードサイズ(単位:MB)
            $uploadMaxFilesize,
            // 画像の場合の仕様で決めたアップロードの最大サイズ(単位:MB)
            $uploadImageMaxFilesize,
            // 今回、アップロードしようとしているファイルのサイズ(単位:バイト数)
            $fileSize
        );
        if($validateRet) {
            /*
                「$.ajax({」で通信しているフロントエンドに対してエラー系で意図通りのメッセージを返すのは、非常に困難である。
                そのため、正常系のNG処理として、responseにメッセージを乗せる
                フロントエンドもjavascriptで動的言語であるため、メンバー値がundefinedでなく値があれば
                ここでのサーバーサイドのバリデーションエラーであることを判定できるし、
                そのメンバー値に入ってる、値でメッセージ表示対応もできるはずだ。
            */
            // 結果を返す
            $ret = new \ArrayObject([
                'validateRet' => $validateRet,
            ], \ArrayObject::ARRAY_AS_PROPS);

            // json返却(HTTPステータス=201:しかし成功ではなくバリデーションエラーの意図での正常系のNG)
            return response()->json($ret, 201);
        }

        /*
            「$fileType->getFolderRelativePath($uuid);」
            にて、動画の場合に、videosのフォルダに保存するように調整してます。

            imagesと、videosに分けて管理するという意図でそうしてますが

            下記の件も視野に入れてます。

            最悪、fly.ioの無料枠で問題なく運用するために
            永続化対象のflyボリュームの要領を空けるため、
            運用データの欠損は、承知の上で「rm -rf videos」でクリアする選択肢が持てるからです。

            その場合、画像についてはデータ守れます。

            単にvideoタグの部分がデータ欠損で表示できなくなったり、
            該当動画のサムネイル画像が表示されないだけです。
            該当の投稿自体を削除するか、該当の投稿のその動画を削除し、
            新たに追加すれば、画面処理を正常に続行できます。
            最悪の選択肢として、「rm -rf videos」でクリアも視野に入れたい
            
            無料枠でのトレーニング用のチーム開発であるがゆえの諸事情です。
            Laravelや、phpのジョージョンが古めでなければ、Cloudflare_R2バケットで10GBまで無期限無料です
            ランニングコストの予算もあれば、もっと潤沢に保存できます。
        */
        // storage/app/public　の配下の相対パス
        $folderRelativePath = $fileType->getFolderRelativePath($uuid);

        /*
            「unused_file_checkers」のinsertを先にやることにしました。

            ファイル保存や、サムネイル画像の保存がうまくいってからと普通は考えますが
            fly.ioの無料枠の問題もあり、また、
            不要ファイルの削除のコマンドが「unused_file_checkers」にデータがあることが
            条件としてあるため、「unused_file_checkers」にデータ登録を先にやっておかないと
            大きな動画は作成できたが、サムネイル画像の生成し、「unused_file_checkers」が未登録状況
            などのケースがあった場合。

            その中途半端に保存された大きな動画だけをピックアップして削除することが困難な状況に
            陥る可能性があります。
            
            それを避けるためには、優先的に、「unused_file_checkers」にデータ登録を先にやる必要があります。
            不要ファイルの削除のコマンドでは、削除すべきと判定されたものにつて、uuidのフォルダごと削除しますが
            実際に、uuidのフォルダがなければ、なにもせず、正常終了する実装になってます。

            ファイル保存もあり、トランザクション制御もしにくいです。
            考えられる対処としては、
            一時的な別領域に保存し、所定の場所に移動がコミット
            一時的な別領域を削除がロールバック
            だと思いますが、それは、余裕があれば、当ロジックで対応するかもしれません。
            今は、「  「unused_file_checkers」のinsert処理  」を先にやる対応だけして保留にしておきます。
        */
        // 「unused_file_checkers」のinsert処理
        UnusedFileChecker::isert($imageType, $uuid, $fileName);

        /*
            保存処理

            config/filesystems.phpの'public'での定義しているフォルダ配下に
            $folderRelativePath$file->getClientOriginalName()のファイル名で保存する。

            返却値を受け取った$filePathの値は、
            例として、
                images/posts/123e4567-e89b-12d3-a456-426614174000/image.jpg
            のような値が格納される

            php artisan storage:link
            での環境設定済の状況では、
            img タグの src属性には、{{ asset('storage/XXX') }} で、XXXに、$filePathの値を指定できる。
        */
        $filePath = $file->storeAs($folderRelativePath, $fileName, 'public');

        if($fileType->isPost && $fileType->isVideo) {
            /*
                postで動画の場合はサムネイル画像を生成する。
            */

            // フォルダの絶対パス
            $folderFullPath = storage_path('app/public/' . $folderRelativePath);

            // 動画ファイルの絶対パス
            $videoFilePath = $folderFullPath . '/' . $fileName;

            // 作成予定のサムネイル画像の絶対パス
            $thumbnailFilePath = $folderFullPath . '/' . "thumbnail.jpg";

            // サムネイル生成処理の実行
            try {
                $helper->generateThumbnailFromVideo($videoFilePath, $thumbnailFilePath);
                \Log::info("サムネイル生成に成功しました: {$thumbnailFilePath}");
            } catch (\Exception $e) {
                \Log::error("サムネイル生成に失敗しました");
                throw $e;
            }
        }

        // 結果を返す
        $ret = new \ArrayObject([
            'uuid' => $uuid,
            'filePath' => $filePath,
        ], \ArrayObject::ARRAY_AS_PROPS);

        // json返却(HTTPステータス=201:Created:作成成功)
        return response()->json($ret, 201);
    }
}
