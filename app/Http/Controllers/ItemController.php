<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        // itemsテーブルのデータを全て取得
        $items = Item::get();
        return view('item.index', compact('items'));
    }

    public function create(Request $request)
    {
        return view('item.create');
    }

    public function store(Request $request)
    {
        // 画像フォームでリクエストした画像を取得
        $img = $request->file('img_path');

        // 画像情報がセットされていれば、保存処理を実行
        if (isset($img)) {
            // storage > public > img配下に画像が保存される
            $path = $img->store('img','public');
            // store処理が実行できたらDBに保存処理を実行
            if ($path) {
                // DBに登録する処理
                Item::create([
                    'img_path' => $path,
                ]);
            }
        }

        //リダイレクト
        return redirect()->route('item.index');
    }
}
