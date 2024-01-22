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
        $countFollowings = $user->following()->count();
        $countFollowers = $user->follower()->count();

        $countFavorites = $user->favorites()->count();
        $posts = $user->posts()->get();
        $totalFavorites = 0;
        foreach ($posts as $post){
            $totalFavorites += $post->favoriteUsers()->count();
        }
        return [
            'countPosts' => $countPosts,
            'countFollowings' => $countFollowings,
            'countFollowers' => $countFollowers,
            'countFavorites' => $countFavorites,
            'totalFavorites' => $totalFavorites
        ];
    }
}
