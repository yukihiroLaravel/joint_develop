<form action="{{ route('comment.update', [$post->id, $comment->id]) }}" method="POST" class="mt-1 mb-1">
    @csrf
    @method('PUT')
    {{--  エラーで再表示する時、どのコメントを編集していたかを保持するための隠しフィールド  --}}
    <input type="hidden" name="edit_comment_id" value="{{ $comment->id }}">
    <div class="form-group comment-edit-form">
        <textarea name="content" class="form-control" rows="2">{{ old('edit_comment_id') == $comment->id ? old('content') : $comment->content }}</textarea>
    </div>
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-link btn-edit-reply-cancel" data-toggle="collapse"
            data-target="#edit-form-{{ $comment->id }}">キャンセル</button>
        <button type="submit" class="btn du-btn-link du-btn-primary btn-edit-reply-post">更新</button>
    </div>
</form>
