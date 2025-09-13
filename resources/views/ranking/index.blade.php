@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center" style="color:#2e5c2b; font-weight:bold;">
        <i class="fas fa-crown text-warning"></i> 人気ランキング TOP10
    </h2>

    @if (empty($rankedPosts))
        <p class="text-center" style="color:#555;">まだランキング対象の投稿はありません。</p>
    @else
        @foreach ($rankedPosts as $item)
            <div class="d-flex justify-content-between align-items-center p-3 mb-3 shadow-sm"
                 style="background:#f9f7f1; border:2px solid #8b5e3c; border-radius:15px;">
                <div>
                    {{-- 順位 --}}
                    <span class="badge badge-warning mr-2">{{ $item['rank'] }} 位</span>

                    {{-- 投稿内容 --}}
                    <a href="{{ route('posts.show', $item['post']->id) }}" style="color:#2e5c2b; font-weight:bold;">
                        {{ $item['post']->content }}
                    </a>
                    <br>
                    <small class="text-muted">投稿者: {{ $item['post']->user->name }}</small>
                </div>

                {{-- いいね数 --}}
                <span class="badge badge-success badge-pill">
                    {{ $item['post']->favorite_users_count }} いいね
                </span>
            </div>
        @endforeach
    @endif
</div>
@endsection