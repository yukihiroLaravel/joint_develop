@extends('layouts.app')
@section('content')
{{-- design-update: ジャンボトロンをヘッダーと同色に変更、ロゴ追加 --}}
<div class="center jumbotron du-hero">
    <div class="text-center mt-2 pt-1">
        <h1 class="du-font-title"><span class="du-hero-title-part">今日の</span><span class="du-hero-title-part">つぶやき</span><img src="/images/logo.svg" alt="今日のつぶやきロゴ" class="du-logo-mark"></h1>
    </div>
</div>
@if (Auth::check())
<h5 class="text-center du-composer-heading mb-3">つぶやきたくなったら<br class="d-block d-sm-none">つぶやくところ</h5>

{{-- design-update: 投稿フォームをカードデザインに変更 --}}
<div class="du-composer-card w-75 mx-auto mb-4">
    @include('commons.error_messages')
    <form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        {{-- design-update: テキストエリア 文字数カウントjavaScript--}}
        <div class="form-group position-relative mb-2">
            <textarea class="form-control du-composer-textarea" name="content" rows="5" placeholder="140文字以内でなにかつぶやいてみよう。" data-char-count-target="du-char-count" data-char-count-max="140">{{ old('content') }}</textarea>
            <span class="du-char-counter"><span id="du-char-count">0</span>/140</span>
        </div>
        {{-- 画像アップロード --}}
        <div class="form-group mt-2">
            <label for="image" class="mb-1 d-block"><i class="fas fa-image mr-1"></i>画像を追加(任意 2MBまで)</label>
            <input type="file" name="image" id="image" class="du-file-image-input">
            <button type="button" id="image-clear" class="btn d-none btn-outline-secondary btn-sm du-btn-small">×解除</button>
        </div>
        <div class="form-group mt-2 du-composer-tag-wrap js-tag-select-wrap">
            @include('posts.tag_checkboxes', ['tagIdPrefix' => 'post-tag-'])
        </div>
        <div class="d-flex justify-content-end du-composer-toolbar">
            <button type="submit" class="du-btn-primary du-btn-link">投稿する</button>
        </div>
    </form>
</div>
<hr class="du-section-divider w-75 mx-auto mt-4 mb-4">
@endif
{{-- 検索エリア --}}
<div class="du-filter-bar w-75 mx-auto mb-4">
    <div class="du-keyword-search-wrap">
        {{-- design-update: キーワード検索 --}}
        <form action="{{ route('posts') }}" method="GET">
            <div class="du-search-input-group mb-2">
                <input type="text" name="keyword" class="form-control du-search-input" placeholder="キーワードで検索（例：ごはん、Laravel、etc.）" value="{{ $keyword ?? '' }}">
                <button type="submit" class="du-search-btn"><i class="fas fa-search"></i></button>
            </div>
            {{-- タグをクリックしたまま、投稿検索をかけた時にタグの情報が残る処理 --}}
            @foreach (request('tags', []) as $tag)
                <input type="hidden" name="tags[]" value="{{ $tag }}">
            @endforeach
        </form>
    </div>
        {{-- design-update: タグ検索 --}}
        <div class="du-tag-filter">
            @isset($allTags)
            @foreach ($allTags as $tag)
            @php
                $currentTags = request('tags', []);
                if (in_array($tag->id, $currentTags)) {
                    // すでに選択中 → 外す（トグルでOFFにする）
                    $newTags = array_diff($currentTags, [$tag->id]);
                } else {
                    // 未選択 → 追加する
                    $newTags = array_merge($currentTags, [$tag->id]);
                }
                $isActive = in_array($tag->id, $currentTags);
            @endphp
            <a href="{{ route('posts', ['tags' => array_values($newTags), 'keyword' => request('keyword')]) }}" class="du-tag-pill-label{{ $isActive ? ' is-active' : '' }}">#{{ $tag->type }}</a>
            @endforeach
            @endisset
        </div>
</div>

{{-- 投稿一覧 --}}
@include('posts.posts', ['posts' => $posts ])
@endsection
