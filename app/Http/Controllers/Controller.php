<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function counts($user) {
        $count_followings = $user->followings()->count();
        $count_followers = $user->followers()->count();
        return [
            'count_followings' => $count_followings,
            'count_followers' => $count_followers,
        ];
    }
}
