@extends('layouts.app')
@section('content')
@php
    $user = $post->user;
@endphp
<div class="text-left d-inline-block w-75 mb-2">
    @include('commons.avatar', [
        'editFlg' => 'OFF',
        'imageSize' => '100',
        'user' => $user,
        'class' => 'mr-2 rounded-circle',
        ])
    <p class="mt-3 mb-0 d-inline-block align-middle"><a href="{{ route('user.show', $user->id) }}" title="{{ $user->name }}"><span style="font-size: 30px;">{{ $user->truncateName() }}</span></a></p>
</div>
<div class="text-left d-inline-block w-75">
    <p class="text-muted">
    <span style="font-size: 30px;">{{ $post->content }}</span>
    </p>
</div>
<hr noshade="">
@foreach ($post->replies as $reply)
<div class="text-left d-inline-block w-75 mb-2">
    @include('commons.avatar', [
        'editFlg' => 'OFF',
        'imageSize' => '55',
        'user' => $reply->user,
        'class' => 'mr-2 rounded-circle',
        ])
    <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $reply->user->id) }}" title="{{ $reply->user->name }}">{{ $reply->user->truncateName() }}</a></p>
</div>
<div class="text-left d-inline-block w-75">
    <p class="text-muted">
    {{ $reply->comment }}
    </p>
</div>
@endforeach
<hr noshade="">
<p class="text-muted"><span style="font-size: 25px;">
    この投稿に返信する
</p></span>
    @include('commons.error_messages')
        <form method="POST" action="{{route('reply.store',$post->id )}}">
            @csrf
            <div class="form-group">
                <textarea id="comment" class="form-control" name="comment" rows="5">{{ old('comment') }}</textarea>
            </div>
            <div class="form-group mt-4">
            <button class="btn btn-success float-right mb-3 mr-3">返信する</button>
            </div>
            <input type="hidden" name='postId' value="{{ $post->id }}">
        </form>
@endsection