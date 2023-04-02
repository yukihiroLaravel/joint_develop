<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    public function edit($id)
    { {
            $user = \Auth::user();
            $movie = Movie::findOrFail($id);
            $movies = $user->movies()->orderBy('id', 'desc')->paginate(9);
            $data = [
                'user' => $user,
                'movie' => $movie,
                'movies' => $movies,
            ];
            return view('movies.edit', $data);
        }
    }
    public function update(MovieRequest $request, $id)
    {
        $movie = Movie::findOrFail($id);
        $movie->youtube_id = $request->youtube_id;
        $movie->title = $request->title;
        $movie->user_id = $request->user()->id;
        $movie->favorite_flag = $request->favorite_flag ? 1 : 0;
        $movie->save();
        return back();
    }
}
