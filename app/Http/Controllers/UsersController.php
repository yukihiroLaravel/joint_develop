<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\UserRequest; 
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

   public function edit($id)
   {
        $user = User::findOrFail($id);       
        if (\Auth::id() === $user->id) {                      
            return view('users.edit',[
                'user' => $user,
            ]);
        }
        return back();
   }
   
   public function update(UserRequest $request, $id)
   {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {        
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);     
            $user->save();           
        }     
        //return redirect('/')->with('update_flash_message', '更新しました');
        return redirect('/')->with([
            'flash_msg' => '更新しました',
            'cls' => 'success'
        ]);
   }

   public function destroy($id)
   {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
           $user->delete();
        }
        //return redirect('/')->with('delete_flash_message', '退会しました');
        return redirect('/')->with([
            'flash_msg' => '退会しました',
            'cls' => 'danger'
        ]);
   }

   public function showFollowingList($id)
   {
       $user = User::findOrFail($id);
       $followings = $user->followings()->orderBy('created_at', 'desc')->paginate(10);
       $data=[
        'user' => $user,
        'followings' => $followings,
       ];
        return view('users.followings', $data);
   }

   public function showFollowerList($id)
   {
       $user = User::findOrFail($id);
       $followers = $user->followers()->orderBy('created_at', 'desc')->paginate(10);
       $data=[
        'user' => $user,
        'followers' => $followers,
       ];
        return view('users.follower', $data);
   }

}