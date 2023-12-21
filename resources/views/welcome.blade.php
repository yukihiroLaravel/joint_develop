{{-- トップページ --}}
@extends('layouts.app')

{{-- 内容 --}}
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3"></i>Topic Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>

    @if(Auth::check())
    {{-- 投稿する --}}
        <div class="text-center mb-3">
            <form method="POST" action="/posts" class="d-inline-block w-75">
                @csrf {{-- CSRFトークンを追加 --}}
                {{-- フラッシュメッセージ表示 --}}
                @include('commons.flash_message')
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="2"></textarea>
                    @error('content') {{-- バリデーションエラーメッセージの表示 --}}
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    {{-- 検索ワード入力 --}}
    <div class="text-right mt-3">
        @include('posts.search')
    </div>

    {{-- 投稿一覧 --}}
    @include('posts.posts', ['posts' => $posts])

@endsection


