<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

class UsersController extends Controller
{
   public function index()
   {
       return view('welcome');
   }  

   public function show($id)
   {
       $user = User::findOrFail($id);
       $posts = $user->posts()->orderBy('id','desc')->paginate(10);
       $data=[
        'user' => $user,
        'posts' => $posts,
       ];
        return view('users.show', $data);
   }

   public function destroy($id)
   {
       $user = User::findOrFail($id);
       if (\Auth::id() === $movie->user_id) {
           $user->delete();
       }
       return back();
   }

}


