@extends('layouts.app')
@section('content')
@include('commons.success')
<div class="w-75 m-auto">@include('commons.error_messages')</div>
<h1 class="text-center mb-3">《お題》</h1>
<div class="text-center mb-3">
    <p class="mt-0 mb-0 d-inline-block">出題：<a href="{{ route('user.show', $posts->user->id) }}">{{$posts->user->name}}</a>さん</p>
</div>
<h2 class="text-center mb-4">{{$posts->text}}</h2>
    <h6 class="text-center mb-3">※新規ユーザ登録してこのお題に回答しよう！</h6>
    @if (Auth::check())
    <div class="text-center mb-3">
        <form method="POST" action="{{ route('comment.store',$posts->id) }}" class="d-inline-block w-75">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="body" rows="4">{{ old('body') }}</textarea>
                <div class="text-left mt-3">
                    <button type="submit" class="btn btn-primary">このお題に回答を投稿する</button>
                </div>
            </div>
        </form>
    </div>
    @endif
    <h1 class="text-center mt-5 mb-3">《みんなの回答》</h1>
    <ul class="list-unstyled">
        @foreach ($comments as $comment)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($comment->user->email, 35) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block">回答：<a href="{{ route('user.show', $comment->user->id) }}">{{$comment->user->name}}</a>さん</p>
                <p class="text-muted d-inline-block ml-4">{{$comment->created_at}}</p>
            </div>
            <div class="">
                <div class="text-left d-inline-block w-75">
                    <p class="text-center mb-2 h4">{{$posts->text}}</p>
                    <p class="text-center text-muted mb-2 h3">{{$comment->body}}</p>
                </div>
                @if (Auth::id() === $comment->user_id)
                <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                    <form method="POST" action="{{ route('comment.delete', [$posts->id, $comment->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                    <a href="" class="btn btn-primary">編集する</a>
                </div>
                @endif
            </div>
        </li>
        @endforeach
    </ul>

    <div class="m-auto" style="width: fit-content">{{ $comments->links('pagination::bootstrap-4') }}</div>
    @endsection