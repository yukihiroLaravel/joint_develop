@extends('layouts.app')
@section('content')
@include('commons.success_messages')
    {{-- 検索フォーム --}}
    <div class="d-flex justify-content-end mb-3 pr-5">
        <form action="{{ route('search') }}" method="GET" class="form-inline d-inline-block">
            <input type="text" name="keyword" class="form-control mr-2" placeholder="キーワードを入力" value="{{ request('keyword') }}">
            <select name="type" class="form-control mr-2">
                <option value="posts" {{ request('type') === 'posts' ? 'selected' : '' }}>投稿</option>
                <option value="users" {{ request('type') === 'users' ? 'selected' : '' }}>ユーザ</option>
            </select>
            <button type="submit" class="btn btn-primary">検索</button>
        </form>
    </div>
    {{-- ヘッダー --}}
    <div class="container">
        <div class="jumbotron bg-info">
            <div class="text-center text-white mt-2 pt-1">
                <h1><i class="fab fa-telegram fa-lg pr-3"></i>Topic Posts</h1>
            </div>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
    {{-- 投稿フォーム（ログイン時のみ） --}}
    @if (Auth::check())     
        <div class="w-75 m-auto">
            @include('commons.error_messages', ['errorBag' => 'post'])
        </div>
        <div class="text-center mb-3">
            <form method="POST" action="{{route('posts.store')}}" enctype="multipart/form-data" class="d-inline-block w-75">
                @csrf
                <div class="form-group">
                    <textarea
                        class="form-control @error('content', 'post') is-invalid @enderror" 
                        name="content"
                        rows="4">{{ old('content', '', 'post') }}</textarea>
                    {{-- 投稿フォームのバリデーション --}}
                    @error('content', 'post')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input type="file" name="images[]" multiple class="form-control-file mt-2">
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
    {{-- 検索結果表示 --}}
    @if (!empty($keyword))
        <div class="w-75 m-auto mb-4">
            <p>「{{ $keyword }}」の検索結果</p>
        </div>
        {{-- ユーザ検索結果 --}}
        @if (isset($users) && $users->isNotEmpty())
            <div class="w-75 m-auto mb-5">
                <h5>ユーザ</h5>
                <ul class="list-unstyled">
                    @foreach ($users as $user)
                        <li class="mb-3">
                            <a href="{{ route('users.show', ['id' => $user->id]) }}">
                                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 50) }}" alt="ユーザのアバター画像">
                                {{ $user->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div>{{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
            </div>
        @endif
        {{-- 投稿検索結果（あれば置き換え、なければ通常タイムライン） --}}
        @if (isset($posts) && $posts->isNotEmpty())
            @include('posts.posts', ['posts' => $posts])
        @else
            {{-- 投稿がなければ通常タイムラインを出す --}}
            @include('posts.posts', ['posts' => $timeline])
        @endif
    @else
        {{-- タイムライン --}}
        @include('posts.posts', ['posts' => $posts])
    @endif
@endsection