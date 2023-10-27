@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>検索結果【検索ワード： {{ $searchQuery }}】</h1>
        @if($searchResults->count() > 0)
            @include('posts.posts', ['posts' => $searchResults, 'searchQuery' => $searchQuery])
        @else
            <p>検索条件に一致する投稿は見つかりませんでした。</p>
        @endif
    </div>
@endsection