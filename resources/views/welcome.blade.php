@extends('layouts.app')
@section('title', '修理どこがいい？クルマの名医ナビ | 車修理のおすすめ整備工場を口コミで探せる')
@section('meta_description', '信頼できる自動車整備工場を口コミ・レビューで探せる車修理特化アプリ。高評価の整備工場を簡単に検索できる。')

@section('content')
<head>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        .custom-title {
            font-family: 'Anton', sans-serif;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
            letter-spacing: 1px;
        }
    </style>
</head>

<body>
<div class="bg-dark text-white py-4 mb-3">
    <div class="container text-center">
        <h1 class="display-4 font-weight-bold custom-title">修理どこがいい？クルマの名医ナビ</h1>
        <p class="lead mt-3">信頼できる自動車整備工場が口コミで見つかる、車修理レビューアプリ</p>
        <div class="mt-4">
            <video controls width="100%" style="max-width: 720px;" class="mx-auto d-block">
                <source src="{{ asset('videos/sample.mp4') }}" type="video/mp4">
                お使いのブラウザは video タグをサポートしていません。
            </video>
        </div>
        {{-- 検索フォーム（共通化） --}}
        <form action="{{ url('/') }}" method="GET" class="mt-4 w-75 mx-auto">
            <div class="input-group">
                <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="fas fa-search"></i> {{-- 虫眼鏡アイコン --}}
            </span>
        </div>
                <input id="keyword" type="text" name="keyword" class="form-control" placeholder="キーワード検索" value="{{ old('keyword', $keyword ?? '') }}">
                <button class="btn btn-primary" type="submit">検索</button>
            </div>
        </form>
    </div>
</div>

{{-- 投稿フォーム（ログインユーザーのみ） --}}
@if (Auth::check())
    <div class="container mb-4">
        <div class="text-center">
            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="w-100">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="3" placeholder="レビューを1000字以内で投稿">{{ old('content') }}</textarea>
                </div>
                <div class="form-group mt-2">
                    <input type="file" name="image" class="form-control-file">
                </div>
                <div class="text-left mt-2">
                    <button type="submit" class="btn btn-primary">投稿する</button>
                </div>
            </form>
        </div>
    </div>
@endif

{{-- エラーメッセージ --}}
<div class="container mb-3">
    @include('commons.error_messages')
</div>

{{-- 新着レビュー --}}
<div class="container mb-5">
    <h3 class="text-center mb-3">🔧 新着レビュー</h3>              
</div>
@include('posts.posts',['posts' => $posts, 'keyword' => $keyword])
@endsection