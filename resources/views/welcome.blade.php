@extends('layouts.app')
@section('content')
<!-- design-update: ジャンボトロンをヘッダーと同色に変更、ロゴを追加 -->
<div class="center jumbotron du-hero">
    <div class="text-center mt-2 pt-1">
        <h1 class="du-font-title">今日のつぶやき<img src="/images/logo.svg" alt="今日のつぶやきロゴ" class="du-logo-mark"></h1>
    </div>
</div>
@if (Auth::check())
{{-- design-update: 見出しは投稿フォームカードの見出しと重複するためコメントアウト --}}
{{-- <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5> --}}

<!-- design-update: 投稿フォームをカードデザインに変更 -->
<div class="du-composer-card w-75 mx-auto mb-4">
    <div class="d-flex align-items-center mb-3">
        {{-- design-update: Gravatarから、丸+頭文字のアバターに変更。Gravatar版はコメントアウトで保持 --}}
        {{-- <img class="du-composer-avatar" src="{{ Gravatar::src(Auth::user()->email, 40) }}" alt="ユーザのアバター画像"> --}}
        <span class="du-avatar-initial du-composer-avatar du-avatar-c{{ Auth::id() % 6 }}">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
        <span class="du-composer-title">つぶやきたくなったらつぶやくところ</span>
    </div>
    @include('commons.error_messages')
    <form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        <!-- design-update: テキストエリア 文字数カウントjavaScript-->
        <div class="form-group position-relative mb-2">
            <textarea class="form-control du-composer-textarea" name="content" rows="4" placeholder="140文字以内でなにかつぶやいてみよう。" id="du-post-content" data-char-count-target="du-char-count" data-char-count-max="140">{{ old('content') }}</textarea>
            <span class="du-char-counter"><span id="du-char-count">0</span>/140</span>
        </div>
        <!-- 画像アップロード -->
        <div class="form-group mt-2">
            <label for="image" class="mb-1 d-block"><i class="fas fa-image mr-1"></i>画像を追加(任意 2MBまで)</label>
            <input type="file" name="image" id="image" class="file-image-input">
            <button type="button" id="image-clear" class="btn btn-light d-none btn-outline-secondary btn-sm btn-small">×解除</button>
        </div>
            {{-- design-update: タグを自由に追加できるハッシュタグ欄。カテゴリ選択ドロップダウンを試すため一旦コメントアウト --}}
            {{--
            <div class="flex-grow-1 mt-3 mt-md-0 ml-md-3">
                <input type="text" class="form-control du-hashtag-input" placeholder="ハッシュタグを追加する">
                <div class="mt-2">
                    <span class="du-tag-pill du-tag-pill-sm">#マイスポット</span>
                    <span class="du-tag-pill du-tag-pill-sm">#今日の空／気分</span>
                    <span class="du-tag-pill du-tag-pill-sm">#お役立ち情報</span>
                    <span class="du-tag-pill du-tag-pill-sm">#マイルーティン</span>
                    <span class="du-tag-pill du-tag-pill-sm">#今日のごはん・おやつ</span>
                </div>
            </div>
            --}}
            <!-- design-update: カテゴリ選択ドロップダウン（（機能未実装）） -->
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
            <button type="submit" class="du-btn-primary du-btn-link">投稿する</button>
        </div>
    </form>
</div>
<!-- design-update: 投稿フォームと検索・タグ行の境目をわかりやすくするための区切り線 -->
<hr class="du-section-divider w-75 mx-auto mt-4 mb-4">
@endif

<!-- design-update: 検索窓・タグ絞り込み行を新規追加 -->
<div class="du-filter-bar w-75 mx-auto mb-4">
    <div class="row align-items-center">
        <!-- design-update: スマホ幅で確実に全幅スタックさせるため col-12 を追加 -->
        <div class="col-12 col-md-4 mb-2 mb-md-0 du-search-wrap">
            <form action="{{ route('posts') }}" method="GET">
                <input type="text" name="keyword" class="form-control du-search-input" placeholder="キーワードで検索（例：ごはん、空、Laravel）" value="{{ $keyword ?? '' }}">
                <button type="submit" class="du-search-btn"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="col-12 col-md-8">
            <!-- design-update: タグ検索用 （機能未実装） -->
            <a href="#" class="du-tag-pill du-tag-pill-sm" onclick="return false;">#マイスポット</a>
            <a href="#" class="du-tag-pill du-tag-pill-sm" onclick="return false;">#今日の空／気分</a>
            <a href="#" class="du-tag-pill du-tag-pill-sm" onclick="return false;">#お役立ち情報</a>
            <a href="#" class="du-tag-pill du-tag-pill-sm" onclick="return false;">#マイルーティン</a>
            <a href="#" class="du-tag-pill du-tag-pill-sm" onclick="return false;">#今日のごはん・おやつ</a>
            <a href="#" class="du-tag-pill du-tag-pill-sm" onclick="return false;">#珍しい名字・地名</a>
            <a href="#" class="du-tag-pill du-tag-pill-sm" onclick="return false;">#とりあえずつぶやきたい</a>
            <a href="#" class="du-tag-pill du-tag-pill-sm" onclick="return false;">#Laravelとか</a>
        </div>
    </div>
</div>

<!-- 投稿一覧 -->
@include('posts.posts', ['posts' => $posts ])
@endsection
