{{-- design-update: 投稿一覧をカードデザインに変更 --}}
<ul class="list-unstyled w-75 du-feed-list m-auto">
    @foreach ($posts as $post)
    <li class="du-post-card mb-4 text-left">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div class="d-flex align-items-center">
                {{-- design-update: 丸+頭文字のアイコンに変更 --}}
                <span class="du-avatar-initial du-post-avatar du-avatar-c{{ $post->user->id % 6 }}">{{ mb_substr($post->user->name, 0, 1) }}</span>
                <div>
                    <a href="{{ route('users.show', $post->user->id) }}" class="du-post-user-name">{{ $post->user->name }}</a>
                </div>
            </div>
            <span class="du-post-time">{{ $post->created_at->format('Y/m/d H:i') }}</span>
        </div>
        {{-- 投稿のタグ --}}
        @if ($post->tags->isNotEmpty())
        <div class="mb-2">
            @foreach ($post->tags as $tag)
            <span class="du-post-tag-pill">#{{ $tag->type }}</span>
            @endforeach
        </div>
        @endif
        <p class="du-post-content text-break">
            <a href="{{ route('posts.show', $post->id) }}">
                {{ $post->content }}
            </a>
        </p>
        @if ($post->image !== null)
        <div class="mt-2 mb-2">
            <img class="img-fluid rounded du-post-image" src="{{ asset('storage/' . $post->image) }}" alt="投稿画像">
        </div>
        @endif
        <div class="du-reaction-row">
            @include('reactions.reaction_button',['post' => $post])
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
    </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
