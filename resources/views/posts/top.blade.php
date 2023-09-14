@extends('layouts.layout')
@section('content')
<div class="center jumbotron bg-success">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="pr-3"></i>Golffer</h1>
    </div>
</div>
<h5 class="text-center mb-3">"Golf"について140字以内で会話しよう！</h5>
@include('layouts.flash')
@if (Auth::check())
<div class="w-75 m-auto">
    @if($errors->any())
        @include('layouts.err')
    @endif
</div>
<div class="text-center mb-3">
    <form method="POST" action="{{ route('post') }}" class="d-inline-block w-75" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <textarea class="form-control" name="content" rows="4">{{ old('content') }}</textarea>
            @include('layouts.image')
            <div class="text-left mt-3">
                <button type="submit" class="btn btn-success">投稿する</button>
            </div>
        </div>
    </form>
</div>
@endif
<ul class="list-unstyled">
    @foreach ($posts as $post)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('users.show', $post->user_id) }}">{{ $post->user->name }}</a></p>
            </div>
            <div class=""> 
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{ $post->content }}</p>
                    <p class="text-muted">{{ $post->created_at }}</p>
                    @if(file_exists(public_path().'/storage/post_img/'. $post->id .'.jpg'))
                        <img src="/storage/post_img/{{ $post->id }}.jpg" width="500px">
                    @elseif(file_exists(public_path().'/storage/post_img/'. $post->id .'.jpeg'))
                        <img src="/storage/post_img/{{ $post->id }}.jpeg" width="500px">
                    @elseif(file_exists(public_path().'/storage/post_img/'. $post->id .'.png'))
                        <img src="/storage/post_img/{{ $post->id }}.png" width="500px">
                    @elseif(file_exists(public_path().'/storage/post_img/'. $post->id .'.gif'))
                        <img src="/storage/post_img/{{ $post->id }}.gif" width="500px">
                    @endif
                    @include('layouts.like')
                </div>
                @if (Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="POST" action="{{ route('posts.delete', $post->id) }}">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-success">編集する</a>
                    </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->links() }}</div>
@endsection