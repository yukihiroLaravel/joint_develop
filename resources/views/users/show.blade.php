@extends('layouts.app')
@section('content')
    <div class="row">
        <aside class="col-sm-4 mb-5">
            @include('layouts.user_profile', ['user' => $user])
        </aside>
        <div class="col-sm-8">
            @include('layouts.user_nav_tabs', ['user' => $user, 'counts' => $counts])
            {{-- 検索ワード入力 --}}
            <div class="mb-3">
                @include('posts.search', ['keyword' => $keyword])
            </div>            
            <!-- ここからタイムライン投稿一覧部分追加 -->
            @include('posts.posts', ['posts' => $posts])
        </div>
    </div>
@endsection
