@extends('layouts.app')

@section('content')
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
        </div>

        <div class="mb-3 d-flex align-items-center">
            <img
                class="mr-3 rounded-circle"
                src="{{ Gravatar::src($post->user->email, 55) }}"
                alt="{{ $post->user->name }}のアバター画像"
            >

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

        <div class="border rounded p-4 mb-5 bg-light">

            <h5 class="font-weight-bold mb-3">
                リアクション集計
            </h5>

            <div class="mb-3">
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
                <div class="font-weight-bold">
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

            @if ($myReaction)
                <form
                    method="POST"
                    action="{{ route('reaction.destroy', $post->id) }}"
                    class="mb-4 d-flex align-items-center"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger mr-3">
                        リアクションを取り消す
                    </button>

                    @if ($myReaction->encouragement)
                        <span class="text-muted">
                            ※ハゲマシも消えます
                        </span>
                    @endif
                </form>
            @endif

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
                    <div class="border rounded p-3 mb-3 d-flex align-items-center">
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

                            <small class="text-muted">
                                by
                                <a href="{{ route('user.show', $reaction->user->id) }}">
                                    {{ $reaction->user->name }}
                                </a>
                            </small>
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