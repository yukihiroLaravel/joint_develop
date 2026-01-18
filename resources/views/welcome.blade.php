@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-8">
        <div class="center jumbotron">
            <div class="text-center mt-2 pt-1">
                <h1>
                    <i class="fas fa-tree"></i> 
                    <span>エンジニアの森</span>
                    <i class="fas fa-tree"></i>
                </h1>
            </div>
        </div>
        <h5 class="text-center mb-3">"今のモヤモヤを140字以内で書き出してみよう！</h5>
        @if (Auth::check())
        @include('posts.form')
        @endif
        @if(!empty($tag) || !empty($keyword))
            <div class="w-75 m-auto alert alert-secondary px-3 py-2 mb-4">
                @if(!empty($tag))
                    タグ <strong>#{{ $tag }}</strong> で絞り込み中
                @endif
                @if(!empty($keyword))
                    キーワード <strong>「{{ $keyword }}」</strong> で検索中
                @endif
                <a href="{{ route('welcome') }}" class="ml-2 text-dark">
                    <i class="fas fa-times-circle"></i> 解除して全件表示
                </a>
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
