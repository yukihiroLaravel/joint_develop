@extends('layouts.app')

@section('content')

    {{-- リアクションドーナツ専用の見た目を読み込む --}}
    @include('posts.partials.reaction_donut_style')

    <div class="w-75 m-auto">
        <h2 class="mt-5 mb-4">やっちゃった詳細</h2>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="border rounded p-4 mb-3 bg-light">
            <p class="font-weight-bold mb-3">
                やっちゃった内容
            </p>

            <p class="mb-0">
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

        <div class="mb-3 d-flex align-items-center">

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
                <p class="font-weight-bold mb-1">
                    やっちゃった人
                </p>

                <a href="{{ route('user.show', $post->user->id) }}">
                    {{ $post->user->name }}
                </a>
            </div>
        </div>

        <p class="text-muted">
            {{ $post->created_at }}
        </p>

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

        <div class="border rounded p-4 mb-5 bg-light">

            <h5 class="font-weight-bold mb-3">
                リアクション集計
            </h5>

            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <p class="font-weight-bold">
                        リアクション総数：{{ $totalReactions }}件
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

        <div class="mt-5">
            <h4 class="font-weight-bold">リアクション</h4>

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
                        class="btn p-3 shadow-sm d-flex flex-column align-items-center mr-2 mb-3 {{ optional($myReaction)->reaction_type === $type ? '' : 'btn-light' }}"
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

            <div class="form-group">
                <label for="encouragement" class="font-weight-bold h5">
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
                    maxlength="30"
                    value="{{ old('encouragement') }}"
                    placeholder="30文字以内で入力できます"
                    onkeydown="if (event.key === 'Enter' && !event.isComposing) { event.preventDefault(); document.getElementById('encouragementSubmitButton').click(); }"
                >

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
            <div class="mt-5">
                <h4 class="font-weight-bold">みんなからのポジティブ</h4>

                @foreach ($encouragementReactions as $reaction)
                    <div class="border rounded p-3 mb-3">
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

                                                    <textarea
                                                        name="content"
                                                        class="form-control mb-2"
                                                        rows="3"
                                                        maxlength="100"
                                                        >{{ $reply->content }}</textarea>

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
                                        class="form-control"
                                        rows="2"
                                        maxlength="100"
                                        placeholder="返信を書く（100文字以内) "
                                    ></textarea>

                                    @error('content')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    返信する
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-4">
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