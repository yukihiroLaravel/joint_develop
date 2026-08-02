@extends('layouts.app')
@section('content')
<!-- design-update: 編集画面をトップページの投稿フォームと同じカードデザインに統一 -->
<div class="du-composer-card w-75 mx-auto mt-4 mb-4">
    <div class="d-flex align-items-center mb-3">
        {{-- design-update: Gravatarから、丸+頭文字のアバターに変更。Gravatar版はコメントアウトで保持 --}}
        {{-- <img class="du-composer-avatar" src="{{ Gravatar::src(Auth::user()->email, 40) }}" alt="ユーザのアバター画像"> --}}
        <span class="du-avatar-initial du-composer-avatar du-avatar-c{{ Auth::id() % 6 }}">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
        <span class="du-composer-title">投稿を編集する</span>
    </div>
    @include('commons.error_messages')
    <form method="POST" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- design-update: テキストエリア（常に全幅・上部） -->
        <div class="form-group position-relative mb-2">
            <textarea class="form-control du-composer-textarea" name="content" rows="4" id="du-edit-content" data-char-count-target="du-edit-char-count" data-char-count-max="140">{{ old('content', $post->content) }}</textarea>
            <span class="du-char-counter"><span id="du-edit-char-count">0</span>/140</span>
        </div>
        <!-- 画像アップロード -->
        @if ($post->image !== null)
        <div class="mb-2">
            <img class="img-fluid rounded post-image" src="{{ asset('storage/' . $post->image) }}" alt="投稿画像">
        </div>
        <div class="form-group mt-2">
            <label for="image" class="mb-1 d-inline"><i class="fas fa-image mr-1"></i>画像を変更</label>
            <input type="file" name="image" id="image" class="file-image-input">
            <button type="button" id="image-clear" class="btn btn-light d-none btn-outline-secondary btn-sm btn-small">×解除</button>
            <div class="form-group mt-2">
                <label for="delete_image" class="mb-1 d-inline bg-primary-subtle"><i class="fas fa-solid fa-times mr-1 "></i><span>画像を削除</span></label>
                <input type="checkbox" name="delete_image" id="delete_image">
            </div>
        </div>
        @else
        <div class="form-group mt-2">
            <label for="image" class="mb-1 d-block "><i class="fas fa-image mr-1"></i>画像を追加(任意 2MBまで)</label>
            <input type="file" name="image" id="image" class="file-image-input">
            <button type="button" id="image-clear" class="btn btn-light d-none btn-outline-secondary btn-sm btn-small">×解除</button>
        </div>
        @endif
        {{-- design-update: タグを自由に追加できるハッシュタグ欄。カテゴリ選択ドロップダウンを試すため一旦コメントアウト --}}
        {{--
        <div class="flex-grow-1 mt-3 mt-md-0 ml-md-3">
            <label class="du-hashtag-label mb-1">ハッシュタグ</label>
            <input type="text" class="form-control du-hashtag-input" placeholder="#ハッシュタグを追加する">
            <div class="mt-2">
                <span class="du-tag-pill du-tag-pill-sm">#マイスポット</span>
                <span class="du-tag-pill du-tag-pill-sm">#今日の空／気分</span>
                <span class="du-tag-pill du-tag-pill-sm">#お役立ち情報</span>
                <span class="du-tag-pill du-tag-pill-sm">#マイルーティン</span>
                <span class="du-tag-pill du-tag-pill-sm">#今日のごはん・おやつ</span>
            </div>
        </div>
        --}}
        <!-- design-update: カテゴリ選択ドロップダウンに変更（見た目のみ・未実装） -->
        <div class="flex-grow-1 mt-3 mt-md-0 ml-md-3">
            <select class="form-control du-hashtag-input">
                <option>カテゴリを選択（任意）</option>
                <option>マイスポット</option>
                <option>今日の空／気分</option>
                <option>お役立ち情報</option>
                <option>マイルーティン</option>
                <option>今日のごはん・おやつ</option>
                <option>珍しい名字・地名</option>
                <option>とりあえずつぶやきたい</option>
                <option>Laravelとか</option>
            </select>
        </div>
        <div class="d-flex justify-content-end du-composer-toolbar">
            <button type="submit" class="du-btn-primary du-btn-link">更新する</button>
        </div>
    </form>
</div>
@endsection
