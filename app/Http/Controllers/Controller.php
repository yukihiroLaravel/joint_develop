<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * データがログインユーザに紐づいているかを検証する。
     * ( NGの場合は403エラーにする。)
     */
    function validateOwnership($targetUserId) {

        if(!\Auth::check()) {
            abort(403);
        }

        if (\Auth::id() !== $targetUserId) {
            abort(403);
        }
    }

    /* #region フラッシュメッセージ関連 */

    /*
        ( アプリの仕様に関係なく車輪としては柔軟性を持たせるため複数件、表示に対応 )
        alert-success: 成功（緑）・・・showFlashSuccess($message)
        alert-danger: エラー（赤）・・・showFlashDanger($message)
        alert-warning: 警告（黄）・・・showFlashWarning($message)
        alert-info: 情報（青）・・・showFlashInfo($message)
        resources/views/commons/flash_messages.blade.php
        にて定義したタグに指定する。
        bootstrap 4のcssのクラスについて、
        class="alert alert-{{ $alertClass }}
        上記のプレースホルダー部分の指定値に応じたメソッドを定義
    */
    /**
     * messageInfosのセッションのフラッシュ値がまだなければ準備する。
     */
    private function prepareFlashMessageInfos() {
        /*
            「if (session('flashMessageInfos')) {」について、
            'messageInfos'の値がある場合( 空の配列[]である場合も含まれる )は、trueとなる。
            'messageInfos'というキーがセッションに存在しない場合、または、
            'messageInfos'というキーが存在するが、その値がnullである場合は、falseとなる。
        */
        if (session('flashMessageInfos')) {
            // 既にある場合は何もしない
            return;
        }

        session()->flash('flashMessageInfos', []);
    }

    /**
     * Laravelフラッシュメッセージの表示の共通処理
     */
    private function showFlashCommon($message, $alertClass)
    {
        // messageInfosのセッションのフラッシュ値がまだなければ準備する。
        $this->prepareFlashMessageInfos();

        $flashMessageInfos = session('flashMessageInfos');

        // 追加
        $flashMessageInfos[] = new \ArrayObject([
            "message" => $message,
            "alertClass" => $alertClass,
        ], \ArrayObject::ARRAY_AS_PROPS);

        // 反映
        session()->flash('flashMessageInfos', $flashMessageInfos);
    }

    /**
     * 「success」にてLaravelフラッシュメッセージの表示をする
     */
    public function showFlashSuccess($message)
    {
        $this->showFlashCommon($message, 'success');
    }

    /**
     * 「danger」にてLaravelフラッシュメッセージの表示をする
     */
    public function showFlashDanger($message)
    {
        $this->showFlashCommon($message, 'danger');
    }

    /**
     * 「warning」にてLaravelフラッシュメッセージの表示をする
     */
    public function showFlashWarning($message)
    {
        $this->showFlashCommon($message, 'warning');
    }

    /**
     * 「info」にてLaravelフラッシュメッセージの表示をする
     */
    public function showFlashInfo($message)
    {
        $this->showFlashCommon($message, 'info');
    }

    /* #endregion */ // フラッシュメッセージ関連


    /**
     * $userに紐づく件数を取得する
     */
    public function userCounts($user)
    {
        $countPosts = $user->posts()->count();
        $countFollowings = $user->followings()->count();
        $countFollowers = $user->followers()->count();
        
        return [
            'countPosts' => $countPosts,
            'countFollowings' => $countFollowings,
            'countFollowers' => $countFollowers,
        ];
    }

    /**
     * 「$user」の投稿を取得する。
     */
    public function postsByUser($user)
    {
        return $user->posts()->orderBy('id', 'desc')->paginate(10);
    }
}
