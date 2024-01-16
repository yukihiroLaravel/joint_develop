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
        $countFavorites = $user->favorites()->count();
        $posts = $user->posts()->get();
        $totalFavorites = 0;
        foreach ($posts as $post){
            $totalFavorites += $post->favoriteUsers()->count();
            $countFavoriteUsers = $post->favoriteUsers()->count();
        }
        // dd($totalFavorites);
        return [
            'countPosts'=>$countPosts,
            'countFavorites'=>$countFavorites,
            'totalFavorites'=>$totalFavorites,
        ];
    }

    public function postCounts($post)
    {
        $countFavoriteUsers = $post->favoriteUsers()->count();
        // dd($totalFavorites);
        return [
            'countFavoriteUsers'=>$countFavoriteUsers,
        ];
    }
}
