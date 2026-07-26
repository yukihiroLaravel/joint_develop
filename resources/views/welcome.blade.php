@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="pr-3"></i>Topic Posts</h1>
    </div>
</div>
@if (Auth::check())
<h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
<div class="w-75 m-auto">@include('commons.error_messages')</div>
<div class="text-center mb-3">
    <form method="post" action="{{ route('posts.store') }}" class="d-inline-block w-75" enctype="multipart/form-data">
        @csrf
        <div class="form-group text-left">
            <textarea class="form-control" name="content" rows="5">{{ old('content') }}</textarea>
            <!-- ここから追加部分 -->
            <!-- design-update: 画像プレビュー＋画像追加ボタンを1つの列にまとめ、ボタンが画像のすぐ下・左寄せになるようにする。カテゴリ欄はその列の右（PC）/下（スマホ）に配置 -->
            <div class="d-flex flex-column flex-md-row align-items-md-end mb-3">
                <div class="du-image-column">
                    <!-- プレビュー表示は一旦非表示にする。 -->
                    <!-- <div class="du-image-drop d-none">
                        <img src="" alt="イメージプレビュー" id="image-preview">
                    </div> -->
                    <!-- 画像投稿 -->
                    <div class="form-group mt-2">
                        <label for="image" class="mb-0"><i class="fas fa-image mr-1"></i>画像を追加(任意)</label>
                        <input type="file" class="du-btn-plain" name='image' id="image">
                    </div>
                </div>
            </div>
            <!-- ここまで -->
            <div class="text-left mt-3">
                <button type="submit" class="btn btn-primary">投稿する</button>
            </div>
        </div>
    </form>
</div>
@endif
<!-- 投稿一覧 -->
@include('posts.posts', ['posts' => $posts ])
@endsection
