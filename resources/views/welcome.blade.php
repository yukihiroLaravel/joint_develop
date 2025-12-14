@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1>
                <!-- <i class="fas fa-chalkboard-teacher pr-3 d-inline"></i> -->
                <img src="{{ asset('images/tokyo-DeafLympic2025_Emblem.jpg') }}"
                     alt="デフリンピック エンブレム"
                     class="mx-2 align-middle"
                     style="height: 130px;">
            </h1>
            <h1><i class="pr-3"></i>TOKYO 2025 デフリンピック</h1>
            <h1>×</h1>
            <h1>コミュニケーション</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">デフアスリートへの応援メッセージを投稿し、自由にシェアしよう！</h5>
        <div class="w-75 m-auto">
            {{-- 共通のエラーメッセージ --}}
            @include('commons.error_messages')
        </div>
            {{-- 投稿フォーム（ログイン時のみ表示） --}}
        <div class="text-center mb-3">
            @if (Auth::check())
                <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control" name="content" rows="4">{{ old('content') }}</textarea>
                        <div class="text-left mt-3">
                            <button type="submit" class="btn btn-primary">投稿する</button>
                        </div>                        
                    </div>                    
                </form>
            @endif            
        </div>
         {{-- ここから 投稿一覧を中央に表示する部分 --}}
        <div class="d-flex flex-column align-items-center mt-4">
        
        @foreach($posts as $post)
            <div class="w-75 mx-auto mb-3">
                {{-- アバター + 名前 + 日時（横並び） --}}
                <div class="d-flex align-items-center mb-2">

                    {{-- アバター --}}
                    <img src="{{ Gravatar::src($post->user->email, 32) }}" alt="ユーザのアバター画像" class="rounded-circle me-4 flex-shrink-0"style="width:40px; height:40px;">               
                    
                    {{-- 名前 --}}
                    <strong><a href="{{ route('user.show', $post->user->id) }}"
                        class="fw-bold text-dark text-decoration-underline">
                        {{ $post->user->name }}
                    </a></strong><br>
                </div>

                <div>
                    {{-- 投稿内容 --}}
                    <p class="mb-0">{{ $post->content }}</p>
                </div>
                <div>
                    {{-- 名前・日時 --}}
                    <small class="text-muted">{{ $post->created_at->format('Y-m-d H:i') }}</small>
                </div>
            </div>
        @endforeach
        <div class="mt-4">
            {{ $posts->links()}}
        </div>
    </div>
@endsection
