@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-8">
   <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3"></i>Topic Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
        <div class="w-75 m-auto">
            @include('commons.flash_messages')
        </div>
        @if (Auth::check())
        <div class="w-75 m-auto">
            @include('commons.error_messages')
        </div>
        <div class="text-center mb-3">
            <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="4"></textarea>
                    <div class="text-left mt-3">
                        <label for="favorite_flag" class="mt-3">
                            <input id="favorite_flag" type="checkbox" name="favorite_flag" value="1" {{ old('favorite_flag', 1) == 1 ? 'checked' : '' }}>
                            いいね！を許可する
                        </label>
                        <br>
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>          
            </form>
        </div>
        @endif
        <div class="card mt-4 mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('welcome') }}">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" placeholder="投稿内容で検索..." value="{{ $keyword ?? '' }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> 検索
                                </button>
                            </div>
                        </div>
                    </form>
                    @if(!empty($keyword))
                        <div class="mt-2 text-right">
                            <a href="{{ route('welcome') }}" class="text-muted small">検索結果をクリア</a>
                        </div>
                    @endif
                </div>
            </div>
@include('posts.posts', ['posts' => $posts])
    </div>
    <aside class="col-sm-4">
        <div class="card">
            <div class="card-header bg-info text-white">いいね！ランキング</div>
            <ul class="list-group list-group-flush">
                @foreach ($ranking_posts as $rank)
                    <li class="list-group-item">
                        <small>
                            <a href="{{ route('user.show', $rank->user->id) }}" class="text-info">
                                {{ $rank->user->name }}
                            </a>
                        </small>
                        <br>
                        <span class="text-dark">
                            {{ Str::limit($rank->content, 30) }}
                        </span>
                        <br>
                        <span class="badge badge-pill badge-primary">{{ $rank->favorite_users_count }} いいね</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </aside>
</div>
@endsection
