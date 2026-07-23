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
    <form method="POST" action="{{ route('post.update', $post->id) }}">
        @csrf
        @method('PUT')
        <!-- design-update: テキストエリア（常に全幅・上部） -->
        <div class="form-group position-relative mb-2">
            <textarea class="form-control du-composer-textarea" name="content" rows="4" maxlength="140" id="du-edit-content" data-char-count-target="du-edit-char-count">{{ old('content', $post->content) }}</textarea>
            <span class="du-char-counter"><span id="du-edit-char-count">0</span>/140</span>
        </div>
        <!-- design-update: 画像プレビュー＋画像追加ボタンを1つの列にまとめ、ボタンが画像のすぐ下・左寄せになるようにする。カテゴリ欄はその列の右（PC）/下（スマホ）に配置 -->
        <div class="d-flex flex-column flex-md-row align-items-md-end mb-3">
            <div class="du-image-column">
                <div class="du-image-drop">
                    <i class="fas fa-image"></i>
                    <span>画像プレビュー</span>
                </div>
                <!-- design-update: 画像投稿機能は未実装。送信されないボタン -->
                <button type="button" class="du-btn-plain mt-1"><i class="fas fa-image mr-1"></i>画像を追加</button>
            </div>
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
            <!-- design-update: カテゴリ選択ドロップダウンに変更（見た目のみ・機能なし。選択しても投稿には反映されない） -->
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
        </div>
        <div class="d-flex justify-content-end du-composer-toolbar">
            <button type="submit" class="du-btn-primary du-btn-link">更新する</button>
        </div>
    </form>
</div>
@endsection
