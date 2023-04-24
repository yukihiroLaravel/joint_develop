<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class FollowController extends Controller
{
    public function store($id)
    {
        \Auth::user()->follow($id);
        return back();
    }

    public function destroy($id)
    {
        \Auth::user()->unFollow($id);
        return back();
    }
}
