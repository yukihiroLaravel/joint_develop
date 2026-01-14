@extends('layouts.app')
@section('content')

    <div class="container">
        <h3 class="mb-4">投稿の編集</h3>
        @include('commons.error_messages')
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
            {{-- 更新フォーム --}}
            <form method="POST" action="{{ route('posts.update', $post) }}">
                @csrf
                @method('PUT')

            {{--本文--}}
                <div class="mb-3">
                    <label class="form-label">本文</label>
                    <textarea name="content" class="form-control" rows="5">{{ old('content', $post->content) }}</textarea>
                </div>

        <div class="d-flex justify-content-between">

            <button type="submit" class="btn btn-primary">更新</button>
            </form>

            {{-- 削除フォーム --}}
            <form action="{{ route('posts.destroy', $post) }}"
                    method="POST"
                    class="mt-3"
                    onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                @method('DELETE')
            
                <button type="submit" class="btn btn-danger">削除</button>
            </form>
        </div>
        <!-- 追加文（丸さん）-->
            <!-- 現在の画像表示 -->
        @if ($post->image)
            <div class="mb-3">
                <p class="mb-1">現在の画像</p>
                <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid mb-2" style="max-height: 200px;">
            </div>
        @else
            <p class="text-muted">画像はありません</p>
        @endif
        <!-- 画像編集ページへのリンク -->
        <a href="{{ route('posts.image.edit', $post) }}" class="btn btn-primary mb-3">画像を編集または追加する</a>

        <!-- 既存タグ -->
        <div class="form-group">
            <label>既存タグ</label><br>
            @foreach($tags as $tag)
                <label class="mr-2">
                    <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}" {{ $post->tags->contains($tag->id) ? 'checked' : '' }}> #{{ $tag->name }}
                </label>
            @endforeach
        </div>

        <!-- 新規タグ -->
        <div class="form-group">
            <label>新規タグ（カンマ区切り）</label>
            <input type="text" name="new_tags" class="form-control">
        </div>
<!-- 追加文（丸さん）-->
    </div>
@endsection