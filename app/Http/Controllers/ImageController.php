<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        // ディレクトリ名
        $dir = 'image';

        // アップロードされたファイル名を取得
        $file_name = $request->file('image')->getClientOriginalName();

        // 取得したファイル名で画像を保存
        $request->file('image')->storeAs('public/' . $dir, $file_name);

        // ファイル情報をDBに保存
        $image = new Image();
        $image->user_id = \Auth::id();
        $image->name = $file_name;
        $image->path = 'storage/app/public/' . $dir . '/' . $file_name;
        $image->save();

        return redirect('/');
    }
}
