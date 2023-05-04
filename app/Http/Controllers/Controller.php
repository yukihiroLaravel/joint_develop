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
        $countPosts = $user->posts()->count();
        $countFollows = $user->follows()->count();
        $countFollowers = $user->followers()->count();
        return [
            'countPosts' => $countPosts,
            'countFollows' => $countFollows,
            'countFollowers' => $countFollowers,
        ];
    }
}
