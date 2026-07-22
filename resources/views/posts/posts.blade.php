<!-- design-update: 投稿一覧をカードデザインに変更 -->
<ul class="list-unstyled w-75 m-auto">
    @foreach ($posts as $post)
    <li class="du-post-card mb-4 text-left">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div class="d-flex align-items-center">
                {{-- design-update: Gravatarから、丸+頭文字のアバターに変更。Gravatar版はコメントアウトで保持 --}}
                {{-- <img class="du-post-avatar" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像"> --}}
                <span class="du-avatar-initial du-post-avatar du-avatar-c{{ $post->user->id % 6 }}">{{ mb_substr($post->user->name, 0, 1) }}</span>
                <div>
                    <a href="{{ route('users.show', $post->user->id) }}" class="du-post-user-name">{{ $post->user->name }}</a>
                    {{-- design-update: フォロー状態表示は見た目のみのダミー（実際のフォロー判定・機能は未接続）。他ユーザーの投稿には「フォロー中」ラベルのみ表示 --}}
                    @if (Auth::check() && Auth::id() !== $post->user_id)
                    <button type="button" class="du-follow-pill is-following du-follow-pill-sm ml-1">フォロー中</button>
                    @endif
                    {{-- design-update: 投稿日時を相対時間表示に変更。元のフル日時表示はコメントアウトで保持 --}}
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
        {{-- design-update: 画像は任意のため、投稿ごとに画像の有無で崩れないようflexで分岐。画像投稿は未実装のため、id%4==0の投稿にのみダミー画像を表示（デモ用） --}}
        {{-- design-update: 画面幅ではなくカード自体の幅で横並び/縦積みを切り替えるため、コンテナクエリ用のdu-post-bodyを使用（同じ投稿一覧をトップページとユーザ詳細ページの狭いカラムの両方で使うため） --}}
        <div class="du-post-body">
            <p class="du-post-content text-break flex-grow-1">{{ $post->content }}</p>
            @if ($post->id % 4 === 0)
            <div class="du-post-image">
                <i class="fas fa-image"></i>
            </div>
            @endif
        </div>
        {{-- design-update: カテゴリ機能は未実装のため、投稿IDから決定的に選んだダミーのカテゴリを表示（見た目のみ） --}}
        @php
            $duCategories = ['マイスポット', '今日の空／気分', 'お役立ち情報', 'マイルーティン', '今日のごはん・おやつ', '珍しい名字・地名', 'とりあえずつぶやきたい', 'Laravelとか'];
            $duCategory = $duCategories[$post->id % count($duCategories)];
        @endphp
        <span class="du-tag-pill du-tag-pill-sm du-post-category">{{ $duCategory }}</span>
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
<div class="m-auto" style="width: fit-content">{{ $posts->links('pagination::bootstrap-4') }}</div>
