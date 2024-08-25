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
     * 「$user」の投稿を取得する。
     */
    public function postsByUser($user)
    {
        return $user->posts()->orderBy('id', 'desc')->paginate(10);
    }

    /**
     * 「$user」および、関連モデルのレコードを削除する。
     */
    protected function deleteUserRelations($user)
    {
        // posts
        $user->posts()->delete();

        // users
        $user->delete();
    }
}
