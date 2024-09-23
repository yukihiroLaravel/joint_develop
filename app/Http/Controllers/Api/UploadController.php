<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UnusedFileChecker;

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
            // img タグで表示できるもの(ファイルサイズ2MBまで)
            'file' => 'required|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imageType = $request->imageType;

        // ファイル取得
        $file = $request->file('file');

        // uuidの作成
        $uuid = \Str::uuid();

        // storage/app/public　の配下の相対パス
        $folderRelativePath = "images/{$imageType}/{$uuid}";

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
        $fileName = $file->getClientOriginalName();
        $filePath = $file->storeAs($folderRelativePath, $fileName, 'public');

        // 「unused_file_checkers」のinsert処理
        UnusedFileChecker::isert($imageType, $uuid, $fileName);

        // 結果を返す
        $ret = new \ArrayObject([
            'uuid' => $uuid,
            'filePath' => $filePath,
        ], \ArrayObject::ARRAY_AS_PROPS);

        // json返却(HTTPステータス=201:Created:作成成功)
        return response()->json($ret, 201);
    }
}
