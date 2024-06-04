@extends('layouts.app')
@section('content')
@include('commons.success_messages')
@include('commons.error_messages')
    <div class="row">
        <aside class="col-lg-4 mb-5">
            @include('layouts.user_profile', ['user' => $user])
        </aside>
        <div class="col-lg-8">
            @include('layouts.user_nav_tabs', ['user' => $user, 'counts' => $counts])
            <!-- キーワード検索 -->
            <div class="search-form-container mb-3">
                @include('posts.search', ['keyword' => $keyword ?? '', 'user' => $user ?? null])
            </div>
            <!-- 検索結果が0件の場合の表示 -->
            @include('commons.no_results_message')
            <!-- ここからタイムライン投稿一覧部分追加 -->
            @include('posts.posts', ['posts' => $posts])
        </div>
    </div>
@endsection
