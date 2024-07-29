@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3"></i>Topic Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"ディズニー"について140字以内で会話しよう！</h5>
    @include('commons.error_messages')
        <div class="w-75 m-auto">
        </div>
        <div class="text-center mb-3">
        @if (Auth::check())
             <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control" name="content" rows="4"></textarea>
                        <div class="text-left mt-3">
                        <label for='image'>画像をアップロード</label>
                        <input type='file' class="form-control" name="image" id="image">                        
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        @endif
        </div>
        @include('posts.posts',['posts'=> $posts])
@endsection