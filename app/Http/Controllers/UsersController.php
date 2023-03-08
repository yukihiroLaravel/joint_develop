<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{   

    public function edit($id)
    {   
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            return view('users.edit', [
                'user' => $user,
            ]);
        }
        return App::abort(404);
    }

    protected function store(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            $user_info_edit = [];
            if ($user_info_edit) {
                $user_info_edit_messageKey = 'infoedit_errorMessage';
                $user_info_edit_flashMessage = __('flshmsg_user_info.edit_faild');
            } else {
                $user_info_edit_messageKey = 'infoedit_successMessage';
                $user_info_edit_flashMessage = __('flshmsg_user_info.edit_success');
            }
            return redirect("/")->with($user_info_edit_messageKey, $user_info_edit_flashMessage);
            // return redirect("/");
        }
        return App::abort(404);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->delete();
            $userquit = [];
            if ($userquit) {
                $messageKey = 'quit_errorMessage';
                $flashMessage = __('flshmsg_user_quit.quit_faild');
            } else {
                $messageKey = 'quit_successMessage';
                $flashMessage = __('flshmsg_user_quit.quit_success');
            }
            return redirect("/")->with($messageKey, $flashMessage);
        }
        return App::abort(404);
    }
    
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        $data = [
            'user' => $user,
            'posts' => $posts,
        ];
       
        return view('users.show',$data);
    }

}
