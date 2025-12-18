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
                    <!-- 投稿本文 -->
                    <div class="form-group">
                        <textarea class="form-control" name="content" rows="4" required>{{ old('content') }}</textarea>
                    </div>
                    <!-- 既存タグ選択 -->
                    <div class="form-group text-left">
                        <label>既存タグ</label><br>
                        @foreach($tags as $tag)
                            <label class="mr-2">
                                <input type="checkbox"name="tag_ids[]"value="{{ $tag->id }}">#{{ $tag->name }}
                            </label>
                        @endforeach
                    </div>
                    <!-- 新規タグ -->
                    <div class="form-group text-left">
                        <label>新規タグ（カンマ区切り）</label>
                        <input type="text" name="new_tags" class="form-control" placeholder="Laravel, PHP">
                    </div>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </form>
                @endif
        </div>
        {{-- ここから 投稿一覧 --}}
            <div class="d-flex flex-column align-items-center mt-4">
                @include('posts.posts')
            </div>
@endsection
