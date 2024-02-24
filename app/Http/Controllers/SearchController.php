<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if ($request->searchWords == null) {
            return redirect('/',);
        } else {
            $searchWords = mb_convert_kana($request->searchWords, 's');
            $arraySearchWords = preg_split('/[\s,]+/', $searchWords, -1, PREG_SPLIT_NO_EMPTY);
            $postsQuery = Post::query();
            $usersQuery = User::query();
            foreach ($arraySearchWords as $searchWord) {
                $postsQuery->orwhere('content', 'LIKE', '%' . $searchWord . '%');
                $usersQuery->orwhere('name', 'LIKE', '%' . $searchWord . '%');
            }
            $posts = $postsQuery->orderBy('id', 'desc')->paginate(10, ["*"], 'posts-page')->appends(["users-page" => $request->input('users-page')]);
            $users = $usersQuery->orderBy('id', 'desc')->paginate(10, ["*"], 'users-page')->appends(["posts-page" => $request->input('posts-page')]);
            $data = [
                'posts' => $posts,
                'users' => $users,
                'searchWords' => $searchWords,
                'arraySearchWords' => $arraySearchWords
            ];
            $activeList = $request->activeList;
            $data += ['activeList' => $activeList];
            return view('welcome', $data);
        }
    }
}
