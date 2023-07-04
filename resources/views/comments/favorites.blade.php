@extends('layouts.app')
@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        @include('users.user_card')
    </aside>
    <div class="col-sm-8">
        @include('users.user_tab')
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
                    @include('favorite.comment_favorite_button', ['comment' => $comment])
                </div>
            </li>
            @endforeach
        </ul>
        <div class="m-auto" style="width: fit-content">{{ $comments->links('pagination::bootstrap-4') }}</div>
    </div>
</div>
@endsection