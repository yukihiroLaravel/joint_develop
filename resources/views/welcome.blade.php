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
                <option value="tags" {{ request('type') === 'tags' ? 'selected' : '' }}>タグ</option>
            </select>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-search"></i> 検索
            </button>
        </form>
    </div>
    {{-- ヘッダー --}}
    <div class="container">
        <div class="jumbotron text-white text-center"
             style="background: url('/images/outdoor.jpg') no-repeat center center;
                    background-size: cover;
                    border-radius: 15px;">
            <div class="overlay" style="background: rgba(0,0,0,0.5); padding: 50px; border-radius: 15px;">
                <h1 class="display-4">
                    <i class="fas fa-campground pr-2"></i>Enjoy the Outdoors
                </h1>
                <p class="lead">キャンプの魅力について語ろう！</p>
            </div>
        </div>
    </div>
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
                    {{-- タグ入力 --}}
                    <input type="text" 
                           name="tags"
                           class="form-control mt-2 @error('tags', 'post') is-invalid @enderror"
                           placeholder="例：キャンプ飯, ソロキャンプ, 登山"
                           value="{{ old('tags', '', 'post') }}">
                    @error('tags', 'post')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    {{-- 画像アップロード --}}
                    <input type="file" name="images[]" multiple class="form-control-file mt-2">
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-success">つぶやく</button>
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
        @if ($type === 'users')
            @if ($users->isNotEmpty())
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
            @else
                <p class="text-center">該当するユーザはいません。</p>
            @endif
        @endif
        {{-- 投稿検索 --}}
        @if ($type === 'posts')
            @if ($posts->isNotEmpty())
                @include('posts.posts', ['posts' => $posts])
            @else
                <p class="text-center">該当する投稿はありません。</p>
            @endif
        @endif
        {{-- タグ検索 --}}
        @if ($type === 'tags')
            @if ($tags->isNotEmpty())
                <div class="w-75 m-auto mb-5">
                    <h5>タグ</h5>
                    <ul class="list-unstyled">
                        @foreach ($tags as $tag)
                            <li class="mb-2">
                                <a href="{{ route('tags.show', $tag->id) }}" class="badge badge-success">
                                    #{{ $tag->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div>{{ $tags->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
                </div>
            @else
                <p class="text-center">該当するタグはありません。</p>
            @endif
        @endif
    @else
        {{-- タイムライン --}}
        @include('posts.posts', ['posts' => $posts])
    @endif
@endsection