<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{

    public function showRegion($region)
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        $posts1 = Post::where("area","=","北海道・東北")->paginate(10);
        $posts2 = Post::where("area","=","関東")->paginate(10);
        $posts3 = Post::where("area","=","中部")->paginate(10);
        $posts4 = Post::where("area","=","近畿")->paginate(10);
        $posts5 = Post::where("area","=","中国・四国")->paginate(10);
        $posts6 = Post::where("area","=","九州・沖縄")->paginate(10);
        $data=[
            'region' => $region,
            'posts' => $posts,
            'posts1' => $posts1,
            'posts2' => $posts2,
            'posts3' => $posts3,
            'posts4' => $posts4,
            'posts5' => $posts5,
            'posts6' => $posts6,
        ];
        return view('welcome2', $data);
    }


    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->post_title = $request->post_title;
        $post->area = $request->area;
        $post->imagepath = $this->saveImage($request->file('imagepath'));
        $post->user_id = $request->user()->id;
        $post->save();
        return back();
    }

    private function saveImage($image)
    {
        
        if($image !== null){

            $imgPath = $image->store('image', 'public');

        return 'storage/' . $imgPath;
        }
        return null;
    }
}
