@extends('layouts.app') 
@section('content')
    @include('posts.posts', ['user' => $user, 'posts' => $posts])~ここにコメントする投稿を表示～（最悪なくても良い？） userがいる？
    @include('comments.index', ['comments' => $comments])
    <h5 class="text-center mb-3">"投稿"について140字以内でコメントをしよう！</h5>
    <div class="container">
        <div class="w-75 m-auto">@include('commons.error_messages')</div>
        <div class="text-center mb-3">
            @auth
                <form method="POST" action="{{ route('comments.store') }}" class="d-inline-block w-75">
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control" name="text" rows="4">{{ old('text') }}</textarea>
                        <div class="text-left mt-3">
                            <button type="submit" class="btn btn-primary">コメントする</button>
                        </div>
                    </div>
                </form>
            @endauth
        </div>
    </div>
@endsection