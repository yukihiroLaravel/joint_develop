@php
    $initialSelectedCategories = \App\CategoryPost::getCategoryIdArrayByPostId($post->id);
@endphp
@extends('layouts.app')
@section('content')
    <h2 class="mt-5">投稿を編集する</h2>
        @include('commons.error_messages')
        <form method="POST" action="{{ route('post.update', $post->id) }}" onsubmit="saveUploadUIInfo(event)">
            @csrf
            @method('PUT')
            <div class="form-group">
                <textarea id="content" class="form-control" name="content" rows="5">{{ old('content', $post->content) }}</textarea>
            </div>

            @include('commons.categories', [
                'initialSelectedCategories' => $initialSelectedCategories,
            ])

            @include('commons.upload', [
                'multiFlg' => 'ON',
                'editFlg' => 'ON',
                'imageType' => 'post',
                'post' => $post,
                'enableVideoFlg' => 'ON',
            ])
            <div style="margin-left: 25px; margin-top: -10px; margin-bottom: 20px; color:red;">
                「投稿画像・動画、YouTube動画」の変更は「更新する」で適用されます。
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">更新する</button>
                <a href="{{ $previousUrl }}" class="btn btn-info">戻る</a>
            </div>
            {{-- 非GETの処理で取得可能にする対応 --}}
            <input type="hidden" name="previousUrl" value="{{ $previousUrl }}">
        </form>
@endsection
