@extends('layouts.app')
@section('content')
@include('commons.success')
<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="fab fa-telegram fa-lg pr-3"></i>みんなの大喜利「GiriGiri」</h1>
    </div>
</div>
<h1 class="text-center mb-3">《新着ボケ》</h1>
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
                @if ($comment->post)
                <p class="text-center mb-2 h4">{{$comment->post->text}}</p>
                <p class="text-center text-muted mb-2 h3">{{$comment->body}}</p>
                @endif
            </div>
            @if (Auth::id() === $comment->user_id)
            <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                <form method="" action="">
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