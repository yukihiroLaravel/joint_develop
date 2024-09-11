<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\PostTooLargeException;

class CustomPostSizeMiddleware
{
    // リクエストが通過するときに実行されるメソッド
    // ここでPOSTリクエストのサイズをチェックし、制限を超えている場合はエラーメッセージを表示します
    public function handle($request, Closure $next)
    {
        // サーバーの post_max_size 設定値を取得
        $max = $this->getPostMaxSize();
    
        // リクエストの全体のサイズを取得して、最大サイズを超えているか確認
        $contentLength = $request->server('CONTENT_LENGTH');
    
        // CONTENT_LENGTH が設定されているか確認
        if ($max > 0 && $contentLength && $contentLength > $max) {
            // ファイルサイズが最大値を超えている場合、エラーメッセージを持ってリダイレクト
            return redirect()->back()->withErrors(['image' => 'ファイルサイズが大きすぎます。最大50MBまでです。']);
        }
    
        // ファイルサイズが制限内であれば、次のミドルウェアや処理に進む
        return $next($request);
    }
    

    // `post_max_size` の設定値をバイト数に変換して取得
    protected function getPostMaxSize()
    {
        // ini_get関数を使って、PHPの設定ファイル（php.ini）から `post_max_size` の値を取得
        // その値を parseSize メソッドで解析し、バイト数に変換する
        return $this->parseSize(ini_get('post_max_size'));
    }

    // `post_max_size` の設定値をバイト単位の数値に変換するメソッド
    protected function parseSize($size)
    {
        // 値の末尾の文字（例えば 'M'、'K'、'G' など）を取得し、単位を小文字に変換
        $unit = strtolower(substr($size, -1));

        // 単位を取り除いた数値部分を取得
        $size = (int) $size;

        // 取得した単位に応じてバイト単位に変換
        // 'G'（ギガバイト）の場合は、数値を1024^3倍に変換
        // 'M'（メガバイト）の場合は、数値を1024^2倍に変換
        // 'K'（キロバイト）の場合は、数値を1024倍に変換
        // 単位がない場合（バイト単位）は、そのままの数値を返す
        switch ($unit) {
            case 'g':
                return $size * 1024 * 1024 * 1024; // ギガバイトをバイトに変換
            case 'm':
                return $size * 1024 * 1024; // メガバイトをバイトに変換
            case 'k':
                return $size * 1024; // キロバイトをバイトに変換
            default:
                return $size; // 単位がない場合はそのまま返す（バイト単位）
        }
    }
}