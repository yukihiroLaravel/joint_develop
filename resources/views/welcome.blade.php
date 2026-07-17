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
                <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
                    @csrf

                    <div class="form-group">
                        <textarea class="form-control" name="content" rows="3">{{ old('content') }}</textarea>

                    @error('content')
                        <div class='alert alert-danger mt-2 text-left'>
                            {{ $message}}
                        </div>
                    @enderror
                        
                    </div>

                    <div class="form-group text-left">
                        <label for="tags">
                            タグ
                        </label>

                        <input
                            type="text"
                            id="tags"
                            name="tags"
                            class="form-control"
                            value="{{ old('tags') }}"
                            placeholder="例：仕事, うっかり, 勘違い"
                        >

                        <small class="form-text text-muted">
                            タグはカンマ区切りで3個まで、1個につき20文字以内で入力してください。
                        </small>

                        @error('tags')
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

        @include('posts.posts', ['posts' => $posts])

@endsection