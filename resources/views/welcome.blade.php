@extends('layouts.app')
@section('content')
    @if (session('messageDelete'))
        <div class="flash_message alert alert-success text-center">
            {{ session('messageDelete') }}
        </div>
    @endif
    <div class="center jumbotron bg-info">
            <div class="text-center text-white mt-2 pt-1">
                <h1><i class="pr-3 fab fa-telegram fa-lg"></i>Topic Posts</h1>
            </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
        <div class="w-75 m-auto">
            @include('commons.error_messages')
        </div>
        <div class="text-center mb-3">
            <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data" class="d-inline-block w-75">
            @csrf
            @if(Auth::check())    
            <div class="form-group">
                <textarea class="form-control" name="text" rows="4"></textarea>
                <div class="d-flex justify-content-between w-100 pb-3 m-auto">
                    <button type="submit" class="btn btn-primary mt-3">投稿する</button>
                    <input type="file" name="image" class="mt-3">
                </div>
                @if (session('messageSuccess'))
                    <div class="flash_message alert alert-success text-center">
                        {{ session('messageSuccess') }}
                    </div>
                @endif
            </div>
            @endif
            </form>
            @foreach ($posts as $post)
            @endforeach
                <div class="d-flex justify-content-start w-75 m-auto">
                    <form action="{{ route('posts.index') }}" method="GET">
                        <input type="text" name="keyword" class="mr-3">
                        <input type="submit" value="投稿内容の検索">
                    </form>
                </div>
            @include('posts.posts')
        </div>
@endsection