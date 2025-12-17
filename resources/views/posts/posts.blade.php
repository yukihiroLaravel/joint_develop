<ul class="list-unstyled w-75 mx-auto">
    @foreach($posts as $post)
        <li class="mb-4">
            {{-- ユーザー情報 --}}
            <div class="d-flex align-items-center mb-2">
                <img class="mr-2 rounded-circle"
                     src="{{ Gravatar::src($post->user->email, 55) }}"
                     alt="ユーザのアバター画像">

                <a href="{{ route('user.show', $post->user->id) }}">
                    {{ $post->user->name }}
                </a>
            </div>

            {{-- 投稿内容 --}}
            <p class="mb-1">{{ $post->content }}</p>

            {{-- 投稿日時 --}}
            <p class="text-muted small">
                {{ $post->created_at->format('Y-m-d H:i') }}
            </p>

            {{-- 操作ボタン --}}
            @if(Auth::id() === $post->user_id)
                <div class="d-flex justify-content-between mt-2">
                    <form method="" action="">
                        <button type="submit" class="btn btn-danger btn-sm">削除</button>
                    </form>
                    <a href="" class="btn btn-primary btn-sm">編集する</a>
                </div>
            @endif
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->links('pagination::bootstrap-4') }}</div>
