<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function usersCounts($user)
    {
        $countFollows = $user->following()->count();
        $countFollowers = $user->followerUsers()->count();
        return [
            'countFollows' => $countFollows,
            'countFollowers' => $countFollowers,
        ];
    }
}
