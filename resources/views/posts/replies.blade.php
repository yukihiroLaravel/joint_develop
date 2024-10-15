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
        <span style="font-size: 30px;">@include('commons.show_content', ['currentContent' => $post->content, ])</span>
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
        @include('commons.show_content', ['currentContent' => $reply->comment, ])
        </p>
        @if(Auth::id() === $reply->user_id)
            <form method="POST" action="{{ route('reply.delete', $reply->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">削除する</button>
            </form>
        @endif
    </div>
    @endforeach
    <hr noshade="">
    @auth
        <p class="text-muted"><span style="font-size: 25px;">
            この投稿に返信する
        </p></span>
        @include('commons.error_messages')
        <form method="POST" action="{{route('reply.store')}}">
            @csrf
            <div class="form-group">
                <textarea id="comment" class="form-control" name="comment" rows="5">{{ old('comment') }}</textarea>
            </div>

            {{-- 
                2024/10/15
                それでいいかは別として、投稿編集画面にあわせ「戻る」を右に一旦する。
                「返信する」のclass属性より「float-right」を一旦削除
                「返信する」と「戻る」縦の位置がそろわなかったため
                devの「class="form-group mt-4"」を「class="d-flex justify-content-between"」に変更した
                「戻る」に「style="height: 38px;"」を書いておかないとデザイン崩れる。38pxは微調整の結果。
            --}}
            <div class="d-flex justify-content-between">
                <button class="btn btn-success mb-3 mr-3">返信する</button>
                <a href="{{ $previousUrl }}" class="btn btn-info" style="margin-top: -2px; width: 95px; height: 38px;">戻る</a>
            </div>
            <input type="hidden" name='postId' value="{{ $post->id }}">
        </form>
    @endauth
@endsection