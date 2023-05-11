<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\User;
use App\Posts;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function userCounts($user)
    {
        $countPosts = $user->posts()->count();
        $countfollowings = $user->followings()->count();
        $countfollowers = $user->followers()->count();
        return [
            'countPosts' => $countPosts,
            'countfollowings' => $countfollowings,
            'countfollowers' => $countfollowers,
        ];
    }
}
