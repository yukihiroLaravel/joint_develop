<!-- design-update: 投稿一覧をカードデザインに変更 -->
<ul class="list-unstyled w-75 du-feed-list m-auto">
    @foreach ($posts as $post)
    <li class="du-post-card mb-4 text-left">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div class="d-flex align-items-center">
                {{-- design-update: Gravatarから、丸+頭文字のアバターに変更。Gravatar版はコメントアウト --}}
                {{-- <img class="du-post-avatar" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像"> --}}
                <span class="du-avatar-initial du-post-avatar du-avatar-c{{ $post->user->id % 6 }}">{{ mb_substr($post->user->name, 0, 1) }}</span>
                <div>
                    <a href="{{ route('users.show', $post->user->id) }}" class="du-post-user-name">{{ $post->user->name }}</a>
                    {{-- design-update: フォロー状態表示は見た目のみのダミー（実際のフォロー判定・機能は未実装）。他ユーザーの投稿には「フォロー中」ラベルのみ表示 --}}
                    @if (Auth::check() && Auth::id() !== $post->user_id)
                    <span class="du-follow-pill is-following du-follow-pill-sm du-btn-link ml-1">フォロー中</span>
                    @endif
                    {{-- design-update: 投稿日時を相対時間表示に変更。元のフル日時表示はコメントアウトで残している --}}
                    {{-- <span class="du-post-time">{{ $post->created_at }}</span> --}}
                    <span class="du-post-time">{{ $post->created_at->locale('ja')->diffForHumans() }}</span>
                </div>
            </div>
            @if (Auth::id() === $post->user_id)
            <div class="du-post-actions">
                <a href="{{ route('post.edit', $post->id) }}" class="du-post-action-link"><i class="fas fa-pen mr-1"></i>編集</a>
                <form method="POST" action="{{ route('post.delete', $post->id) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="du-post-action-link du-post-action-danger"><i class="fas fa-trash mr-1"></i>削除</button>
                </form>
            </div>
            @endif
        </div>
        <p class="du-post-content text-break">{{ $post->content }}</p>
        @if ($post->image !== null)
        <div class="mt-2 mb-2">
            <img class="img-fluid rounded post-image" src="{{ asset('storage/' . $post->image) }}" alt="投稿画像">
        </div>
        @endif
        {{-- design-update: カテゴリ機能は未実装のため、一部の投稿にダミーのカテゴリを表示（見た目のみ） --}}
        @php
        $duCategories = ['マイスポット', '今日の空／気分', 'お役立ち情報', 'マイルーティン', '今日のごはん・おやつ', '珍しい名字・地名', 'とりあえずつぶやきたい', 'Laravelとか'];
        $duCategory = $duCategories[$post->id % count($duCategories)];
        @endphp
        <span class="du-tag-pill du-tag-pill-sm du-post-category">#{{ $duCategory }}</span>
        <div class="du-reaction-row">
            @include('reactions.reaction_button',['post' => $post])
            {{-- design-update: 複数リアクション・コメント機能は未実装のため装飾アイコンのみ（数字なし・クリック不可） --}}
            <!-- <span class="du-reaction-decorative">👍</span>
            <span class="du-reaction-decorative">☕</span>
            <span class="du-reaction-decorative">✨</span>
            <span class="du-reaction-decorative">🎉</span>
            <span class="du-reaction-decorative">😊</span> -->
            <span class="du-reaction-divider">｜</span>
            <span class="du-reaction-decorative"><i class="far fa-comment"></i></span>
        </div>
    </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
