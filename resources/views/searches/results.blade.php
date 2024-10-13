@extends('layouts.app')
@section('content')
    @php
        require_once app_path('Helpers/ViewHelper.php');
        $viewHelper = \App\Helpers\ViewHelper::getInstance();

        $isActivePostsSearch = Request::routeIs('post.search');
        $isActiveUsersSearch = Request::routeIs('user.search');
    @endphp
    <h5 class="text-center mb-3">「{{ $viewHelper->getSearchConditionString($q, $c) }}」の検索結果</h5>
    <ul class="nav nav-tabs nav-justified mb-3">
        <li class="nav-item"><a href="{{ route('post.search', ['q' => $q, 'c' => $c,]) }}" class="nav-link {{ $isActivePostsSearch ? 'active' : '' }}">ポスト</a></li>
        <li class="nav-item">
            @if ($q)
                {{-- キーワードの検索条件がある時：ユーザーのタブ切替ができる --}}
                <a href="{{ route('user.search', ['q' => $q, 'c' => $c,]) }}" class="nav-link {{ $isActiveUsersSearch ? 'active' : '' }}">ユーザー</a>
            @else
                {{-- キーワードの検索条件がない時：ユーザーのタブ切替ができない --}}
                <a href="#" style="cursor: not-allowed;" title="カテゴリでのユーザーの検索結果の表示はできない">ユーザー</a>
            @endif
        </li>
    </ul>

    @if ($isActivePostsSearch)
        @include('posts.search', ['posts' => $posts])
    @endif

    @if ($isActiveUsersSearch)
        @include('users.search', ['users' => $users])
    @endif

@endsection
