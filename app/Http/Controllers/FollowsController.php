<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class FollowsController extends Controller
{
    public function store(Request $request, $otherUserId)
    {
        $otherUser = User::find($otherUserId);
        if(is_null($otherUser)) {
            $this->showFlashWarning("退会済の人です。");
            return back()->with([
                'followsOperationBack' => true,
            ]);
        }

        $ret = \Auth::user()->follow($otherUserId);
        if($ret) {
            $this->showFlashSuccess("{$otherUser->name} さんをフォローしました。");
        }

        return back()->with([
            'followsOperationBack' => true,
        ]);
    }
    
    public function destroy(Request $request, $otherUserId)
    {
        $otherUser = User::find($otherUserId);
        if(is_null($otherUser)) {
            $this->showFlashWarning("退会済の人です。");
            return back()->with([
                'followsOperationBack' => true,
            ]);
        }

        $ret = \Auth::user()->unfollow($otherUserId);
        if($ret) {
            $this->showFlashSuccess("{$otherUser->name} さんをフォロー解除しました。");
        }

        return back()->with([
            'followsOperationBack' => true,
        ]);
    }
}
