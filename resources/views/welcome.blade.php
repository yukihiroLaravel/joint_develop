@extends('layouts.app')
@section('content')

@include('partials.skip_posts_flash_message')

    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <script src="https://kit.fontawesome.com/a3db3ef673.js" crossorigin="anonymous"></script>
            <h1><i class="fa-solid fa-headphones-simple"></i>&nbsp;Music Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">【音楽】に関する情報を140字以内でシェアしよう！</h5>
    <div class="container">
        <div class="w-75 m-auto">@include('commons.error_messages')</div>
        <div class="text-center mb-3">
            @auth
                <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control" name="text" rows="4">{{ old('text') }}</textarea>
                        <div class="text-left mt-3">
                            <button type="submit" class="btn btn-primary">投稿する</button>
                        </div>
                    </div>
                </form>
            @endauth
            @include('posts.posts', ['posts' => $posts])
        </div>
    </div>
@endsection