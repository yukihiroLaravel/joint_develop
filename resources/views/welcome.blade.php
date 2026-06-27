@extends('layouts.app')
@section('content')
    <!-- 投稿一覧 -->
    @include('posts.posts', ['posts' => $posts])
@endsection
