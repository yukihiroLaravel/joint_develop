@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/post-detail.css') }}">
@endpush

@section('content')

    {{-- リアクションドーナツ専用の見た目を読み込む --}}
    @include('posts.partials.reaction_donut_style')

    <div class="w-75 m-auto">
        <h1 class="mt-3 mb-4 text-center">
            <img
                src="{{ asset('images/post-logo.png') }}"
                alt=""
                class="img-fluid post-detail-logo"
            >
            <span class="sr-only">やっちゃった詳細</span>
        </h1>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div
            class="post-detail-main-card rounded mb-3 shadow-sm"
        >
            <div class="post-detail-main-card-body p-4">
                <p class="mb-3">
                    <span
                        class="post-detail-main-label d-inline-block px-3 py-1 rounded-pill font-weight-bold"
                    >
                        やっちゃった内容
                    </span>
                </p>

                <p class="post-detail-main-content mb-0">
                    {{ $post->content }}
                </p>

                @if ($post->tags->isNotEmpty())
                    <div class="mt-3">
                        @foreach ($post->tags as $tag)
                            <a
                                href="{{ route('tag.show', $tag->id) }}"
                                class="badge mr-1"
                                style="background-color: #97b7a4; color: #ffffff;"
                            >
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                @if ($post->image_path)
                    <div class="mt-3">
                        <img
                            src="{{ asset('storage/' . $post->image_path) }}"
                            alt="添付画像"
                            class="img-fluid rounded border bg-white"
                            style="max-height: 400px; width: auto; object-fit: contain;"
                        >
                    </div>
                @endif
            </div>

        </div>

            <div class="post-detail-meta mb-4">

                <div class="post-detail-user mb-3 d-flex align-items-center">

                    @if ($post->user->avatar)
                        <img
                            class="mr-3 rounded-circle"
                            src="{{ asset('storage/' . $post->user->avatar) }}"
                            alt="{{ $post->user->name }}のアバター画像"
                            width="55"
                            height="55"
                        >
                    @else
                        <img
                            class="mr-3 rounded-circle"
                            src="{{ Gravatar::src($post->user->email, 55) }}"
                            alt="{{ $post->user->name }}のアバター画像"
                        >
                    @endif

                    <div>
                        <p class="post-detail-user-label mb-1">
                            やっちゃった人
                    </p>

                        <a
                            href="{{ route('user.show', $post->user->id) }}"
                            class="post-detail-user-name"
                        >
                            {{ $post->user->name }}
                        </a>
                    </div>

                </div>

                <div class="post-detail-created-at">
                    {{ $post->created_at }}
                </div>
            </div>

        @php
            $donutStart = 0;
            $donutSegments = [];

            foreach ($reactionTypes as $type => $label) {
                $count = $reactionCounts[$type] ?? 0;

                if ($totalReactions > 0 && $count > 0) {
                    $donutEnd = $donutStart + (($count / $totalReactions) * 100);
                    $donutSegments[] = ($reactionColors[$type] ?? '#adb5bd') . ' ' . $donutStart . '% ' . $donutEnd . '%';
                    $donutStart = $donutEnd;
                }
            }

            $donutBackground = count($donutSegments) > 0
                ? 'conic-gradient(' . implode(', ', $donutSegments) . ')'
                : 'conic-gradient(#e9ecef 0% 100%)';
        @endphp

        <div
            class="post-detail-reaction-panel rounded p-4 mb-5 shadow-sm"
        >

            <h5 class="post-detail-reaction-heading font-weight-bold mb-3">
                リアクション集計
            </h5>

            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <p class="font-weight-bold d-flex align-items-baseline">
                        <span>リアクション総数：</span>
                        <span class="post-detail-reaction-total text-success">
                            {{ $totalReactions }}件
                        </span>
                    </p>

                    @foreach ($reactionTypes as $type => $label)
                        <div class="d-flex align-items-center mb-2">
                            <img
                                src="{{ asset('images/reactions/' . $type . '.png') }}"
                                alt="{{ $label }}"
                                class="mr-2"
                                style="width: 40px; height: 40px; object-fit: contain;"
                            >

                            <div>
                                <span class="font-weight-bold">
                                    {{ $label }}
                                </span>

                                <span class="ml-2">
                                    {{ $reactionCounts[$type] ?? 0 }}件
                                    ({{ $reactionPercentages[$type] ?? 0 }}%)
                                </span>
                            </div>
                        </div>
                    @endforeach

                    @if ($maxReactionCount > 0)
                        <div class="font-weight-bold mt-3">
                            最多リアクション:

                            @foreach ($maxReactionTypes as $type)
                                <div class="d-flex align-items-center mt-2">
                                    <img
                                        src="{{ asset('images/reactions/' . $type . '.png') }}"
                                        alt="{{ $reactionTypes[$type] }}"
                                        style="width: 40px; height: 40px;"
                                        class="mr-2"
                                    >

                                    <span>
                                        {{ $reactionTypes[$type] }}
                                        ({{ $maxReactionCount }}件)
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>
                            まだリアクションはありません
                        </p>
                    @endif
                </div>

                {{-- 集計カード右側に、ドーナツ部品を配置する --}}
                @include('posts.partials.reaction_donut')
            </div>
        </div>

        <div
            class="post-detail-reaction-panel mt-5 rounded p-4 shadow-sm"
        >
            <h4 class="post-detail-reaction-heading font-weight-bold">リアクション</h4>

            <p class="text-muted mb-3">
                {{ $myReaction ? 'リアクションは変更できるよ' : 'あなたのリアクションを選んでね' }}
            </p>

            <form id="reactionForm" method="POST">
                @csrf
            </form>

            <div class="d-flex flex-wrap mb-3">
                @foreach ($reactionTypes as $type => $label)
                    <button
                        type="submit"
                        form="reactionForm"
                        formaction="{{ route('reaction.store', $post->id) }}"
                        name="reaction_type"
                        value="{{ $type }}"
                        class="reaction-button btn p-3 shadow-sm d-flex flex-column align-items-center mr-2 mb-3 {{ optional($myReaction)->reaction_type === $type ? '' : 'btn-light' }}"
                        style="width: 120px; {{ optional($myReaction)->reaction_type === $type ? 'background-color: #ffe4ec; border-color: #f5a8bd;' : '' }}"
                    >
                        <img
                            src="{{ asset('images/reactions/' . $type . '.png') }}"
                            alt="{{ $label }}"
                            style="width: 80px; height: 80px; object-fit: contain;"
                        >

                        <small class="mt-2">
                            {{ $label }}
                        </small>

                        <small class="mt-1 font-weight-bold">
                            {{ $reactionCounts[$type] ?? 0 }}件
                        </small>
                    </button>
                @endforeach

            </div>

            @error('reaction_type')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror

            {{-- To Minamiさん：上の各ボタンの下にリアクション集計をそれぞれ表示させるイメージかと思います --}}

            <div
                class="post-detail-encouragement-panel form-group rounded p-4 mt-4 shadow-sm"
            >
                <label
                    for="encouragement"
                    class="post-detail-encouragement-label font-weight-bold h5 d-inline-block px-3 py-1 rounded-pill"
                >
                    ひとことハゲマシ
                </label>

                @if (! optional($myReaction)->encouragement)
                    <p class="text-muted mb-2">
                        ハゲますこともできます！
                    </p>
                @endif

                @if (optional($myReaction)->encouragement)
                    <div class="border-left pl-3 py-2 mb-3" style="border-left-width: 4px !important; border-left-color: #f5a8bd !important;">
                        <p class="font-weight-bold mb-1">
                            あなたからのハゲマシ
                        </p>

                        <p class="mb-0">
                            {{ $myReaction->encouragement }}
                        </p>
                    </div>
                @endif

                <input
                    id="encouragement"
                    type="text"
                    name="encouragement"
                    form="reactionForm"
                    class="form-control"
                    value="{{ old('encouragement') }}"
                    placeholder="30文字以内で入力できます"
                    onkeydown="if (event.key === 'Enter' && !event.isComposing) { event.preventDefault(); document.getElementById('encouragementSubmitButton').click(); }"
                >

                <div class="text-right text-muted small mt-1">
                    <span id="encouragement-count">0</span> / 30文字
                </div>

                <div
                    id="encouragement-error"
                    class="alert alert-danger mt-2 d-none"
                >
                    30文字以内で入力してください。
                </div>

                @error('encouragement')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-flex align-items-center">
                <button
                    id="encouragementSubmitButton"
                    type="submit"
                    form="reactionForm"
                    formaction="{{ route('reaction.encourage', $post->id) }}"
                    class="btn btn-primary mr-3"
                >
                    ハゲます
                </button>

                @if (optional($myReaction)->encouragement)
                    <span class="text-muted">
                        ※ハゲマシが更新されます
                    </span>
                @endif
            </div>
        </div>

        @if ($encouragementReactions->count() > 0)
            <div
                class="post-detail-positive-panel mt-5 rounded p-4 shadow-sm"
            >
                <h4
                    class="post-detail-positive-heading font-weight-bold mb-4"
                >
                    みんなからのポジティブ
                </h4>

                @foreach ($encouragementReactions as $reaction)
                    <div
                        class="post-detail-positive-card border rounded p-3 mb-3 bg-white shadow-sm"
                    >
                        <img
                            src="{{ asset('images/reactions/' . $reaction->reaction_type . '.png') }}"
                            alt="{{ $reactionTypes[$reaction->reaction_type] }}"
                            class="mr-3"
                            style="width: 56px; height: 56px; object-fit: contain;"
                        >

                        <div>
                            <p class="mb-1">
                                {{ $reaction->encouragement }}
                            </p>

                            @if ($reaction->replies->count() > 0)
                                <div class="mt-3 pl-3 border-left">
                                    <p class="font-weight-bold mb-2">
                                        返信
                                    </p>

                                    @foreach ($reaction->replies as $reply)
                                        <div class="mb-2">
                                            <p class="mb-1 text-break">
                                                {{ $reply->content }}
                                            </p>

                                            <small class="text-muted">
                                                by
                                                <a href="{{ route('user.show', $reply->user->id) }}">
                                                    {{ $reply->user->name }}
                                                </a>
                                            </small>

                                            @if (Auth::id() === $reply->user_id)
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-primary mt-2"
                                                    onclick="document.getElementById('edit-reply-{{ $reply->id }}').style.display='block'"
                                                >
                                                    編集
                                                </button>
                                            @endif

                                            @if (Auth::id() === $reply->user_id)
                                                <form
                                                    id="edit-reply-{{ $reply->id }}"
                                                    method="POST"
                                                    action="{{ route('reaction_replies.update', $reply->id) }}"
                                                    class="mt-2"
                                                    style="display:none;"

                                                >
                                                    @csrf
                                                    @method('PUT')

                                                    <textarea name="content" class="form-control mb-2 js-character-count" rows="3" maxlength="100" data-max-length="100">{{ $reply->content }}</textarea>

                                                    <div class="text-right mb-2">
                                                        <small>
                                                            <span class="js-character-count-display">
                                                                {{ mb_strlen($reply->content) }}
                                                            </span>
                                                            /100文字
                                                        </small>
                                                    </div>

                                                    <div class="js-character-count-error text-danger mb-2"></div>

                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        更新
                                                    </button>

                                                    @error('content')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </form>
                                            @endif

                                            @if (Auth::id() === $reply->user_id)
                                                <form
                                                    method="POST"
                                                    action="{{ route('reaction_replies.destroy', $reply->id) }}"
                                                    class="mt-2"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('この返信を削除しますか？')"
                                                    >
                                                        削除
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <form method="POST" action="{{ route('reaction_replies.store',          [$post->id, $reaction->id]) }}">
                            @csrf

                                <div class="form-group mt-3">
                                    <textarea
                                        name="content"
                                        class="form-control reply-content"
                                        rows="2"
                                        placeholder="返信を書く（100文字以内) "
                                    ></textarea>

                                    <small class="d-block text-right text-muted mt-1">
                                        <span class="reply-character-count">0</span> / 100文字
                                    </small>
                                    
                                    <div class="alert alert-danger mt-2 d-none reply-character-error">
                                        100文字以内で入力してください。
                                    </div>

                                    @error('content')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary reply-submit-button">
                                    返信する
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="post-navigation">
            <a href="/" class="btn btn-secondary mr-2">
                トップへ
            </a>

            <a href="{{ route('user.show', $post->user->id) }}" class="btn btn-outline-secondary">
                {{ $post->user->name }}さんのページへ
            </a>
        </div>
    </div>
@endsection

{{-- リアクションドーナツ専用JavaScriptを読み込む --}}
@include('posts.partials.reaction_donut_script')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const encouragement = document.getElementById('encouragement');
    const encouragementCount = document.getElementById('encouragement-count');
    const encouragementError = document.getElementById('encouragement-error');
    const submitButton = document.getElementById('encouragementSubmitButton');
    const reactionButtons = document.querySelectorAll('.reaction-button');

    if (encouragement && encouragementCount && encouragementError && submitButton) {

        function updateEncouragementCount() {
            const count = encouragement.value.length;

            encouragementCount.textContent = count;

            if (count > 30) {
                encouragementCount.classList.add('text-danger');
                encouragementError.classList.remove('d-none');
                submitButton.disabled = true;

                reactionButtons.forEach(function (button) {
                    button.disabled = true;
                });

            } else {
                encouragementCount.classList.remove('text-danger');
                encouragementError.classList.add('d-none');
                submitButton.disabled = false;

                reactionButtons.forEach(function (button) {
                    button.disabled = false;
                 });                
            }
        }

        encouragement.addEventListener('input', updateEncouragementCount);

        updateEncouragementCount();
    }

    document.querySelectorAll('.reply-content').forEach(function (textarea) {

        const form = textarea.closest('form');

        if (!form) {
        return;
        }

        const counter = form.querySelector('.reply-character-count');
        const error = form.querySelector('.reply-character-error');
        const submitButton = form.querySelector('.reply-submit-button');

        if (!counter || !error || !submitButton) {
            return;
        }

        function updateReplyCount() {
            const count = textarea.value.length;

            counter.textContent = count;

            if (count > 100) {
                counter.classList.add('text-danger');
                error.classList.remove('d-none');
                submitButton.disabled = true;
            } else {
                counter.classList.remove('text-danger');
                error.classList.add('d-none');
                submitButton.disabled = false;
            }
        }

        textarea.addEventListener('input', updateReplyCount);

        updateReplyCount();
    });

});
</script>
@endpush
{{-- リアクション成功時だけ紙吹雪を読み込む --}}
@if (session()->has('reaction_confetti'))
    @include('posts.partials.reaction_confetti_script', [
        'reactionType' => session('reaction_confetti'),
    ])
@endif
