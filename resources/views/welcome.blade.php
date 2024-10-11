@php
    require_once app_path('Helpers/ViewHelper.php');
    $viewHelper = \App\Helpers\ViewHelper::getInstance();
@endphp
@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="fab fa-telegram fa-lg pr-3"></i>{{ config('app.TopicPostsTitle') }}</h1>
        </div>
    </div>
    <h5 class="text-center mb-3"><img src="{{ asset('img/tamori.png') }}" style="margin-top: -5px;" alt="Tamori">な気分の話題について140字以内で会話しよう！</h5>
    @auth
        <div class="w-75 m-auto">@include('commons.error_messages')</div>
        <div class="text-center mb-3">
            <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75" onsubmit="saveUploadUIInfo(event)">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="4">{{ old('content') }}</textarea>

                    @include('commons.categories', [
                        'initialSelectedCategories' => [],
                    ])

                    @include('commons.upload', [
                        'multiFlg' => 'ON',
                        'editFlg' => 'OFF',
                        'imageType' => 'post',
                        'enableVideoFlg' => 'ON',
                    ])
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        </div>
    @endauth
    @foreach ($posts as $post)

        @php
            $user = $post->user;

            //「$followsParam」を作成する。
            $followsParam = $viewHelper->createFollowsParam($user);
        @endphp

        @include('posts.show', ['user' => $user, 'post' => $post, 'followsParam' => $followsParam])
    @endforeach
    <div class="m-auto" style="width: fit-content">
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
@endsection
