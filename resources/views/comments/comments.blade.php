@extends('layouts.app')
@section('content')
@include('commons.success')
<div class="w-75 m-auto">@include('commons.error_messages')</div>
<h1 class="text-center mb-3">《 お 題 》</h1>
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
                <textarea class="form-control" name="body" rows="4" placeholder="回答を入力してください">{{ old('body') }}</textarea>
                <div class="text-left mt-3">
                    <button type="submit" class="btn btn-primary">このお題に回答を投稿する</button>
                </div>
            </div>
        </form>
    </div>
    @endif
    <h1 class="text-center mt-5 mb-3">《みんなの回答》</h1>
    @include('comments.comment_list')
    <div class="m-auto" style="width: fit-content">{{ $comments->links('pagination::bootstrap-4') }}</div>
@endsection