@php
    // 閉じる対象のid(投稿へのコメント: comment-form / 返信: reply-form-親コメントID)
    $collapseId = $parentId === null ? 'comment-form' : 'reply-form-' . $parentId;
@endphp
@auth
    <div class="comment-form-section mt-3">
        <form class="comment-form" method="POST" action="{{ route('comment.store', $post->id) }}">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $parentId }}">
            <div class="form-group">
            <textarea name="content" class="form-control comment-input" rows="2" placeholder="コメントを入力...">{{ old('edit_comment_id') === null && old('parent_id') == $parentId ? old('content') : '' }}</textarea>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-link btn-comment-cancel" data-toggle="collapse"
                    data-target="#{{ $collapseId }}">キャンセル</button>
                <button type="submit" {{-- 親コメントの時はコメント投稿、返信の時は返信と表示 --}}
                    class="btn d-flex justify-content-end du-btn-primary du-btn-link {{ $parentId ? 'btn-reply-post' : 'btn-comment-post' }}">{{ $parentId ? '返信' : 'コメント投稿' }}</button>
            </div>

        </form>
    </div>
@endauth
