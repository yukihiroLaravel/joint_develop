<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Post;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function userCounts($user)
    {
        $countPosts = $user->posts()->count();
        $countFollowings = $user->follows()->count();
        $countFollowers = $user->followed()->count();
        $countFavorites = $user->favorites()->count();

        return [
            'countPosts' => $countPosts,
            'countFollowings' => $countFollowings,
            'countFollowers' => $countFollowers,
            'countFavorites' => $countFavorites,
        ];
    }

    protected function getRanking()
    {
        return Post::withCount('favoriteUsers')
                   ->orderBy('favorite_users_count', 'desc')
                   ->take(5)
                   ->get();
    }
}
