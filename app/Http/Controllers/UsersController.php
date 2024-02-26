<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;
use App\Post;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'posts' => $posts,
        ];
        $data += $this->userCounts($user);
        
        return view('users.show', $data);
    }
    

    public function edit($id)
    {
        $user = User::findOrFail($id);
        if(\Auth::check() && \Auth::id() == $user->id){
            $data=[
                'user' => $user,
            ];
            return view('users.edit',$data);
        }else{
            abort(404);
        };
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if(\Auth::check() && \Auth::id() == $user->id){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
            $data =[
                'user'=> $user,
                'posts' => $posts,
            ];
            return view('users.show',$data);
        }else{
            abort(404);
        };
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->delete();            
        }
        return redirect('/');              
    }
    
}