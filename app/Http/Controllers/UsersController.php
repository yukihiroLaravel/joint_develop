<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\User;

class UsersController extends Controller
{
    use SoftDeletes;

    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        $data = [
        'user' => $user,
        'posts' => $posts,
        ];
        $data += $this->userCounts($user);

        return view('users.show', $data);
    }

    public function index()
    {
        return view('welcome');
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

}
