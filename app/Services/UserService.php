<?php

namespace App\Services;

class UserService
{
    // ユーザ詳細のタブに件数を表示するcount関数
    // FatControllerになるのを防ぐため、ユーザ詳細の一部機能をServiceに記載
    public static function userCounts($user)
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
}
