<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function userCounts($user)
    {
        // 現在postテーブルが無い為post実装後に本格実装予定
        $countPosts = $user/*->posts()*/->count();
        return [
            'countPosts' => $countPosts,
        ];
    }

}
