@extends('layouts.app')
@section('content')
@include('commons.success_messages')
    <div class="center jumbotron bg-color">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="fas fa-snowboarding mr-1"></i><span class="app-title-font">趣味共有館</span></h1>
        </div>
    </div>
    <h5 class="text-center mb-3">あなたの趣味についてシェアしましょう！</h5>
    @if (Auth::check()) <!-- ビューファイル内で直接認証をチェックし認証済みユーザのみにフォームを表示 -->
        <div class="w-75 m-auto">
            @include('commons.error_messages')
        </div>
        <div class="text-center mb-3">
            <form method="POST" action="{{ route('posts.store') }}" class="d-inline-block w-75"> <!-- フォームの送信方法 (method) と送信先 (action) の属性を指定 -->
                @csrf
                <div class="form-group">
                    <!-- ユーザが投稿内容を入力するための部分 -->
                    <textarea class="form-control" name="content" placeholder="本文を入力（例：サッカー観戦楽しかった！）" rows="4">{{ old('content') }}</textarea> <!-- rows="4"と指定（テキストエリアは初期状態で4行分の高さを持つ） -->
                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-primary">投稿</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
    <!-- 検索フォームを追加 -->
    <div class="text-center mb-3 search-form-container">
        @include('posts.search', ['keyword' => $keyword ?? '', 'user' => $user ?? null])
    </div>
    <!-- 検索結果の表示 -->
    @include('commons.no_results_message')
    <!-- 投稿一覧を表示するコンテンツを追加 -->
    <div class="post-list">
        <!--　第一引数　postsフォルダのposts.blade.phpファイルを表示　-->
        <!--  第二引数　「$posts」を配列の形で記述し、第一引数のposts.blade.phpに持っていき表示させる-->
        @include('posts.posts',['posts' => $posts])
    </div>
@endsection
