<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //ユーザ退会
    public function destroy($id)
    {
        // 自分以外のユーザは退会できない
        if ((int) $id !== Auth::id()) {
            abort(403);
        }

        $user = User::findOrFail($id);
        $user->delete();

        Auth::logout();

        return redirect('/');
    }
}
