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
            <div class="card w-75 mb-3 shadow-sm">

                <div class="card-body">

                    {{-- 投稿者名＋日時 --}}
                    <div class="d-flex align-items-center mb-2">
                        <strong class="me-2">{{ $post->user->name }}</strong>
                        <small class="text-muted">{{ $post->created_at }}</small>
                    </div>

                    {{-- 投稿内容 --}}
                    <p class="mb-0">
                        {{ $post->content }}
                    </p>

                </div>
            </div>
        @endforeach
        <div class="mt-4">
            {{ $posts->links()}}
        </div>
    </div>
@endsection
