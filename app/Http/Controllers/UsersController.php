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
      
      return view('users.timeline',$data);
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
    public function followings($id)
    {
        $user = User::findOrFail($id);
        $followings = $user->followings()->paginate(9);
        $data = [
            'user' => $user,
            'followings' => $followings,
        ];
        $data +=$this->userCounts($user);
        return view('users.followings', $data);
    }

    /**
     *フォローワーの表示
     */
    public function followers($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->paginate(9);
        $data = [
            'user' => $user,
            'followers' => $followers,
        ];
        $data +=$this->userCounts($user);
        return view('users.followers', $data);
    }
}
