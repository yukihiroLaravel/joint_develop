@extends('layouts.app')
@section('content')
    <div class="text-center py-2">
    <h1>
        <img src="{{ asset('images/main-logo.png') }}" alt="Topic Posts" class="img-fluid" style="max-height: 240px;">
    </h1>
    </div>

    <h5 class="text-center mb-3">"今日のやらかし"についてシェアしよう！</h5>

        @if (Auth::check())
            <div class="text-center mb-3">
                <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data" class="d-inline-block w-75">
                    @csrf

                    <div class="form-group">
                        <textarea class="form-control" name="content" rows="3">{{ old('content') }}</textarea>

                    @error('content')
                        <div class='alert alert-danger mt-2 text-left'>
                            {{ $message}}
                        </div>
                    @enderror

                    </div>

                    @include('commons.tag_autocomplete', [
                        'tagValue' => old('tags'),
                    ])

                    <div class="form-group text-left">
                        <label for="image">
                            画像を添付（任意）
                        </label>

                        <input 
                        type="file" 
                        class="form-control-file" 
                        id="image" 
                        name="image" 
                        accept="image/*"
                        >
                     
                        <small class="form-text text-muted">
                            対応形式: jpeg, png, jpg, gif（最大2MBまで）
                         </small>
                        
                         @error('image')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">やらかしをシェア</button>
                    </div>
                </form>
            </div>
        @endif

        <div class="d-flex justify-content-center mb-4">
            <div class="w-75">
                <form action="{{ route('posts.index') }}" method="GET">
                    <div class="input-group">
                        <input 
                            type="text" 
                            name="search" 
                            class="form-control" 
                            placeholder="キーワードを入力して検索..." 
                            value="{{ request('search') }}"
                        >
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i> 検索
                            </button>
                        </div>
                    </div>
                </form>

                @if(request('search'))
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <p class="text-muted small mb-0">
                            <strong>「{{ request('search') }}」</strong> の検索結果 ({{ $posts->total() }}件)
                        </p>
                        <a href="{{ route('posts.index') }}" class="btn btn-sm btn-link text-secondary p-0">検索をクリア</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="w-75 m-auto mb-4">
            <h4 class="font-weight-bold" style="color:#FFD700;">
                🏆 人気ランキング
            </h4>

            @php
                $rank = 0;
                $previousCount = null;
            @endphp

            @forelse ($rankingPosts as $index => $post)
                @php
                    if ($post->reactions_count !== $previousCount) {
                        $rank = $index + 1;
                        $previousCount = $post->reactions_count;
                    }
                @endphp

                <div class="p-3 mb-2 bg-light w-75 mx-auto">
                    <div class="font-weight-bold mb-2">
                        @if ($rank === 1)
                            <span class="text-warning">🥇 1位</span>
                        @elseif ($rank === 2)
                            <span class="text-secondary">🥈 2位</span>
                        @elseif ($rank === 3)
                            <span style="color:#cd7f32;">🥉 3位</span>
                        @else
                            <span>{{ $rank }}位</span>
                        @endif
                    </div>

                    <a href="{{ route('post.show', $post->id) }}">
                        {{ $post->content }}
                    </a>

                    <div class="small text-muted">
                        投稿者:
                        <span class="font-weight-bold text-dark">
                            {{ $post->user->name }}
                        </span>
                    </div>

                    <div class="text-muted">
                        リアクション数：
                        <span class="font-weight-bold text-success">
                            {{ $post->reactions_count }}件
                        </span>
                    </div>
                </div>
            @empty
                <p>まだリアクションがありません。</p>
            @endforelse

        </div>
        @include('posts.posts', ['posts' => $posts])

@endsection