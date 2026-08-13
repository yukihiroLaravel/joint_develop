@extends('layouts.app')
@section('content')
<h2 class="text-center du-composer-heading mt-4 mb-3">投稿を編集する</h2>

{{-- design-update: 編集画面をトップページの投稿フォームと同じカードデザインに統一 --}}
<div class="du-composer-card w-75 mx-auto mb-4">
    @include('commons.error_messages')
    <form method="POST" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        {{-- design-update: テキストエリア --}}
        <div class="form-group position-relative mb-2">
            <textarea class="form-control du-composer-textarea" name="content" rows="5" id="du-edit-content" data-char-count-target="du-edit-char-count" data-char-count-max="140">{{ old('content', $post->content) }}</textarea>
            <span class="du-char-counter"><span id="du-edit-char-count">0</span>/140</span>
        </div>
        {{-- 画像アップロード --}}
        @if ($post->image !== null)
        <div class="mb-2">
            <img class="img-fluid rounded du-post-image" src="{{ asset('storage/' . $post->image) }}" alt="投稿画像">
        </div>
        <div class="form-group mt-2">
            <label for="image" class="mb-1 d-block"><i class="fas fa-image mr-1"></i>画像を変更</label>
            <input type="file" name="image" id="image" class="du-file-image-input">
            <button type="button" id="image-clear" class="btn btn-light d-none btn-outline-secondary btn-sm du-btn-small">×解除</button>
            <div class="form-group mt-2">
                <label for="delete_image" class="mb-1 d-inline bg-primary-subtle"><i class="fas fa-solid fa-times mr-1 "></i><span>画像を削除</span></label>
                <input type="checkbox" name="delete_image" id="delete_image">
            </div>
        </div>
        @else
        <div class="form-group mt-2">
            <label for="image" class="mb-1 d-block "><i class="fas fa-image mr-1"></i>画像を追加(任意 2MBまで)</label>
            <input type="file" name="image" id="image" class="du-file-image-input">
            <button type="button" id="image-clear" class="btn btn-light d-none btn-outline-secondary btn-sm du-btn-small">×解除</button>
        </div>
        @endif
        <div class="form-group mt-2 du-composer-tag-wrap js-tag-select-wrap">
            {{-- タグ選択 --}}
            @include('posts.tag_checkboxes', ['tagIdPrefix' => 'edit-tag-'])
        </div>
        <div class="d-flex justify-content-end du-composer-toolbar">
            <button type="submit" class="du-btn-primary du-btn-link">更新する</button>
        </div>
    </form>
</div>
@endsection
