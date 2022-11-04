<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Http\Requests\UserEditRequest;

class UsersController extends Controller
{
   public function show($id)
   {
      $user = User::findOrFail($id);
      $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
      $data=[
         'user' => $user,
         'posts' => $posts,
      ];
      $data += $this->userCounts($user);
      
      return view('users.show',$data);
   }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        if(\Auth::id() === $user->id) {
            return view('users.edit', [
                'user' => $user
            ]);
        }
        abort(404);
    }

    public function update(UserEditRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if(\Auth::id() === $user->id) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect('/users/'. $user->id);
        }
    }
}



