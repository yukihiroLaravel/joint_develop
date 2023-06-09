<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\UserRequest;


class UsersController extends Controller
{
    public function edit($id)
    {
        if ($id == \Auth::id()) 
        {
            $user = User::findOrFail($id);
            $data=[
                'user' => $user,
            ];
            return view('users.edit', $data);
        }
        return view('errors.404');
    }

    public function update(UserRequest $request, $id)
    {
        if ($id == \Auth::id()) 
        {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();            
        }
        return redirect('/');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($id == \Auth::id()) 
        {
            $user->delete();
        }
        return redirect('/');
    }

    public function show($id)
    {
      $user = User::findOrFail($id);
      $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
      $data=[
        'user' => $user,
        'posts' => $posts,
      ];
      return view('users.show',$data);
    }

}
