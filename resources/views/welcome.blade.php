@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3"></i>駅伝について語り尽くそう!!</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"駅伝"について140字以内で会話しよう！</h5>
    @include('commons.error_messages')
    <div class="w-75 m-auto">
        @include('commons.flash_messages')
    </div>
    <div class="text-center mb-3">
        @if(Auth::check())
            <form method="POST" action="{{ route('posts.store') }}" class="d-inline-block w-75">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="4"></textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
    <!-- フラッシュメッセージの表示 -->
    @if(session('flashSuccess'))
        <div class="alert alert-success text-center">
            {{ session('flashSuccess') }}
        </div>
    @elseif(session('flash_msg') && request()->routeIs('posts.index'))
    <div class="alert {{ session('cls') }} text-center">
        {{ session('flash_msg') }}
    </div>
    @endif
    
    @if(isset($keyword_result) && !empty($keyword_result))
        <div class="alert alert-info text-center">
            {{ $keyword_result }}
        </div>
    @endif
    @include('posts.posts', ['posts' => $posts])
@endsection
