<h6 class="comment-title mt-3">コメント</h6>
<ul class="comments-list">
    @forelse ($post->comments as $comment)
        <li class="">
            <div class="comment-user d-flex justify-content-between">
                <a class="d-flex align-items-center" href="{{ route('users.show', $comment->user->id) }}">
                    <span
                        class="du-avatar-initial du-comment-avatar du-avatar-c{{ $comment->user->id % 6 }} mr-2">{{ mb_substr($comment->user->name, 0, 1) }}</span>
                    <span class="comment-user-name">{{ $comment->user->name }}</span>
                </a>
                {{-- コメントした日時 --}}
                <span class="comment-date text-muted">{{ $comment->created_at->format('Y/m/d H:i') }}</span>
            </div>
            <div class="comment-body d-flex justify-content-between">
                <p class="comment-content text-break">{{ $comment->content }}</p>
                {{-- コメント削除ボタン --}}
                @if (Auth::id() === $comment->user_id)
                    <form action="{{ route('comment.delete', [$post->id, $comment->id]) }}" method="POST"
                        class="js-comment-delete-form d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">削除</button>
                    </form>
                @endif
            </div>
        </li>
    @empty
        <li class="comment-notExist text-muted">コメントはまだありません。</li>
    @endforelse
</ul>
