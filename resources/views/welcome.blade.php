@extends('layouts.app')
@section('content')
    <div class="text-center py-2">
    <h1>
        <img src="{{ asset('images/main-logo.png') }}" alt="Topic Posts" class="img-fluid" style="max-height: 240px;">
    </h1>
    </div>

    <h5 class="text-center mb-3">"今日のやらかし"についてシェアしよう！</h5>

        @if (Auth::check())
            <div class="text-center mb-3">
                <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data" class="d-inline-block w-75">
                    @csrf

                    <div class="form-group">
                        <textarea
                            class="form-control js-character-count" name="content" rows="3" data-max-length="100">{{ old('content') }}</textarea>

                        <div class="text-right mt-1">
                            <small>
                                <span class="js-character-count-display">0</span> / 100文字
                            </small>
                        </div>

                        <div class="js-character-count-error text-danger mt-1"></div>

                    @error('content')
                        <div class='alert alert-danger mt-2 text-left'>
                            {{ $message}}
                        </div>
                    @enderror

                    </div>

                    @include('commons.tag_autocomplete', [
                        'tagValue' => old('tags'),
                    ])

                    <div class="form-group text-left">
                        <label for="image">
                            画像を添付（任意）
                        </label>

                        <div id="drop-area" class="border rounded p-4 text-center bg-light" style="cursor:pointer;">
                            <p class="mb-2">📷</p>
                            <p class="mb-1">
                                ここに画像をドラッグ＆ドロップ
                            </p>
                            <small class="text-muted">
                                またはクリックして画像を選択
                            </small>

                            <input
                            type="file"
                            id="image"
                            name="image"
                            accept="image/*"
                            hidden
                            >
                        </div>

                        <div class="text-center mt-3">
                            <img
                                id="preview"
                                class="img-fluid d-none"
                                style="
                                width:100%;
                                max-width:500px;
                                height:300px;
                                object-fit:contain;
                                "
                            >

                            <div class="mt-2">
                                <button
                                    type="button"
                                    id="remove-image"
                                    class="btn btn-sm btn-outline-danger d-none"
                                >
                                    × 画像を削除
                                </button>
                            </div>
                        </div>

                        <small class="form-text text-muted">
                            対応形式: jpeg, png, jpg, gif（最大2MBまで）
                        </small>

                        @error('image')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">やらかしをシェア</button>
                    </div>
                </form>
            </div>
        @else
            {{-- 未ログイン時は、投稿と検索の利用条件を案内する --}}
            <div class="text-center mb-3">
                <p class="mb-1">
                    ログインすると「やらかし」を投稿できます。
                </p>
                <p class="text-muted mb-0">
                    検索はログインしなくてもご利用いただけます。
                </p>
            </div>
        @endif

        {{-- 検索フォームは共通パーツを利用 --}}
        @include('commons.search_form', [
            'search' => $search,
            'scope' => $scope,
            'scopeLabels' => $scopeLabels,
        ])

        {{-- 空欄検索のときだけ、入力を促すメッセージを表示する --}}
        @if ($isEmptySearch)
            <div class="w-75 m-auto">
                <div class="alert alert-warning" role="alert">
                    検索キーワードを入力してください。
                </div>
            </div>
        @endif

        {{-- 検索しているときだけ、ランキングより先に検索結果を表示 --}}
        @if ($hasSearch)
            @include('commons.search_results', [
                'search' => $search,
                'scope' => $scope,
                'scopeLabels' => $scopeLabels,
                'canSearchEncouragements' => $canSearchEncouragements,
                'posts' => $posts,
                'users' => $users,
                'encouragements' => $encouragements,
                'reactionTypes' => $reactionTypes,
            ])
        @endif

        <div class="ranking-section">

            <div class="mb-4">
            <h4 class="font-weight-bold ranking-title" style="color:#000000;">
                🏆 人気ランキング
            </h4>

            @php
                $rank = 0;
                $previousCount = null;
            @endphp

            @forelse ($rankingPosts as $index => $post)
                @php
                    if ($post->reactions_count !== $previousCount) {
                        $rank = $index + 1;
                        $previousCount = $post->reactions_count;
                    }
                @endphp

                <div class="p-3 mb-2 bg-light w-75 mx-auto">
                    <div class="font-weight-bold mb-2">
                        @if ($rank === 1)
                            <span class="text-warning">🥇 1位</span>
                        @elseif ($rank === 2)
                            <span class="text-secondary">🥈 2位</span>
                        @elseif ($rank === 3)
                            <span style="color:#cd7f32;">🥉 3位</span>
                        @else
                            <span>{{ $rank }}位</span>
                        @endif
                    </div>

                    <a href="{{ route('post.show', $post->id) }}"style="color: #111111 !important;">
                        {{ $post->content }}
                    </a>

                    <div class="small text-muted">
                        投稿者:
                        <span class="font-weight-bold text-dark">
                            {{ $post->user->name }}
                        </span>
                    </div>

                    <div class="text-muted">
                        リアクション数：
                        <span class="font-weight-bold text-success">
                            {{ $post->reactions_count }}件
                        </span>
                    </div>
                </div>
            @empty
                <p>まだリアクションがありません。</p>
            @endforelse

            </div>
        </div>
        {{-- 検索していない通常のトップページでだけ、投稿一覧を表示 --}}
        @if (! $hasSearch)
            <div class="post-topic">
                今日のやらかし
            </div>

            @include('posts.posts', ['posts' => $posts])
        @endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const dropArea = document.getElementById('drop-area');
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('preview');
    const removeButton = document.getElementById('remove-image');

    if (!dropArea || !imageInput || !preview) {
        return;
    }

    dropArea.addEventListener('click', function () {
        imageInput.click();
    });

    imageInput.addEventListener('change', function () {
        if (this.files.length > 1) {
            alert('画像は1枚だけ選択してください。');
            this.value = '';
            return;
        }

        previewImage(this.files[0]);
    });

    function previewImage(file) {
        if (!file) return;

        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            removeButton.classList.remove('d-none');
        };

        reader.readAsDataURL(file);
    }

    dropArea.addEventListener('dragover', function (e) {
        e.preventDefault();
        dropArea.classList.add('border-primary');
    });

    dropArea.addEventListener('dragleave', function () {
        dropArea.classList.remove('border-primary');
    });

    dropArea.addEventListener('drop', function (e) {
        e.preventDefault();

        dropArea.classList.remove('border-primary');

        const files = e.dataTransfer.files;

        if (files.length > 1) {
            alert('画像は1枚だけ選択してください。');
            return;
        }

        if (files.length === 1) {
            imageInput.files = files;
            previewImage(files[0]);
        }
    });

    removeButton.addEventListener('click', function () {
        imageInput.value = '';
        preview.src = '';
        preview.classList.add('d-none');
        removeButton.classList.add('d-none');
    });

});
</script>
@endpush
