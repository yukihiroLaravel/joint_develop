@extends('layouts.app')
@section('content')
<div class="container">

    <h4>投稿編集</h4>
    @include('commons.error_messages')

    <form method="POST" action="{{ route('posts.update', $post) }}">
        @csrf
        @method('PUT')

        <!-- 本文 -->
        <div class="form-group">
            <textarea class="form-control" name="content" rows="4" required>{{ old('content', $post->content) }}</textarea>
        </div>

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

        <button class="btn btn-primary">更新する</button>
    </form>

</div>
@endsection