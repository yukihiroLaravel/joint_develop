@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="pr-3"></i>Topic Posts</h1>
    </div>
</div>
<h5 class="text-center mb-3">"あなたの未来"について140字以内で発信しましょう！</h5>
    <div class="w-75 m-auto">@include('commons.error_messages')</div>
    @if(Auth::check())
        <div class="text-center mb-3">
            <form method="POST" action="{{ route('posts.post', Auth::user()->id) }}" class="d-inline-block w-75">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="4"></textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
    @foreach ($posts as $post)
        <div>
            <ul class="list-unstyled">
                <li class="mb-3 text-center">
                    <div class="text-left d-inline-block w-75 mb-2">
                        <img class="mr-2 rounded-circle" src="{{ Gravatar::src( $post->user->email , 55) }}" alt="ユーザのアバター画像">
                        <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('users.show', $post->user->id) }}">{{ $post->user->name }}</a></p>
                    </div>
                    <div class="">
                        <div class="text-left d-inline-block w-75">
                            <p class="mb-2">{{ $post->content }}</p>
                            <p class="text-muted">{{ $post->created_at }}</p>
                        </div>
                            @if(Auth::check() && Auth::user()->id == $post->user_id)
                                <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                                    <form method="POST" action="{{ route('posts.delete', $post->id ) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">削除</button>
                                    </form>
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">編集する</a>
                                </div>
                            @endif
                        </div>
                    </li>
                </ul>
            <div class="m-auto" style="width: fit-content"></div>
        </div>
    @endforeach
    {{ $posts->links('pagination::bootstrap-4') }}
@endsection