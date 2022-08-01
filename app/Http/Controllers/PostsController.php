<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use App\Http\Requests\MovieRequest;

class PostsController extends Controller
{
   public function store()
   {
       $user = \Auth::user();
       $data = [
           'user' => $user,
           'posts' =>$posts,
       ];
    }
    public function index()
   {
       $posts = Post::orderBy('id', 'desc')->paginate(10);
       
       return view('welcome', [ 
            'posts' => $posts,
            
       ]);
   }
}
