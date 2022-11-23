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

    /**
     *ユーザー退会
     * @param int $id
     * @return view
     */
    public function delete($id){
        $user = User::findOrFail($id);
        if(\Auth::id() === $user->id) {
            $user->delete();
            return redirect(route('home'));
        }

        \Session::flash('err_msg', 'アクセス権限がありません。');
        return redirect(route('home'));
    }

    /**
    *フォロー中ユーザーの表示
    */
    public function follow($id)
    {
        $user = User::find($id);
        $followings = $user->followings()->paginate(9);
        $data = [
            'user' => $user,
            'users' => $followings,
        ];
        $data +=$this->conts($user);
        return view('users.show', $data);
    }
    

    /**
     * フォロー解除
     */
    public function unfollow($id)
    {
        $follower = auth()->user();
        $is_following = $follower->isFollowing($user->id);
        if($is_following){
            $follower->unfollow($user->id);
            return back();
        }
    }

}



