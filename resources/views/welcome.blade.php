@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="cat1"><img src="{{ asset('storage/images/cat1.svg') }}" alt="猫"></div>
        <div class="text-center text-white">
            <h1 class="d-flex align-items-center justify-content-center"><span
                    class="top-icon mr-1 d-flex align-items-center justify-content-center"><i
                        class="fa-solid fa-paw"></i></span><b>にゃんにゃんPosts</b></h1>
            <form method="GET" action="{{ action('PostsController@index') }}"
                class="col-lg-6 col-md-8 col mr-auto ml-auto search_form">
                @csrf
                <input type="hidden" name="activeList" value="{{ isset($activeList) ? $activeList : 'posts' }}">
                <input type="text" name="searchWords" value="{{ isset($searchWords) ? $searchWords : '' }}"
                    class="form-control input-group-prepend" placeholder="検索する">
                <button type="submit" class="input-group-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
    <h5 class="text-center mb-3">"ねこ"について140字以内で語ろう！</h5>
    <div class="w-75 m-auto">@include('commons.error_messages')</div>
    @if (Auth::check())
        <div class="text-center mb-3 pt-3">
            <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="4">{{ old('content') }}</textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn_accent-color">投稿する</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
    <ul class="show_category_list list-unstyled">
        <li class="category_btn posts_btn" id="posts">投稿</li>
        <li class="category_btn users_btn" id="users">ユーザー</li>
    </ul>
    <div class="category_container posts_container active">
        @include('posts.posts')
    </div>
    <div class="category_container users_container">
        @include('users.users')
    </div>
@endsection
