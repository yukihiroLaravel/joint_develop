@php
    $maxIndentDepth = 2; // インデントする最大の階層(これより深い返信はフラットに表示)
@endphp
<li class="comment-list-item">
    <div class="comment-container mb-2 mt-2">
        <div class="comment-user d-flex justify-content-between">
            <a class="d-flex align-items-center" href="{{ route('users.show', $comment->user->id) }}">
                <span
                    class="du-avatar-initial du-comment-avatar du-avatar-c{{ $comment->user->id % 6 }} mr-2">{{ mb_substr($comment->user->name, 0, 1) }}</span>
                <span class="comment-user-name">{{ $comment->user->name }}</span>
            </a>
            {{-- コメントした日時 --}}
            <span class="comment-date text-muted">{{ $comment->created_at->format('Y/m/d H:i') }}
                @if ($comment->updated_at->gt($comment->created_at))
                    （編集済み）
                @endif
            </span>
        </div>
        <div class="comment-body">
            <p class="comment-content">
                {{-- フラット表示の返信には、返信先のユーザー名を表示 --}}
                @if ($depth > $maxIndentDepth)
                    <span class="comment-reply-to">{{ '@' . $comment->parent->user->name }}</span>
                @endif
                <span class="comment-text text-break">{{ $comment->content }}</span>
            </p>
            {{-- 返信/編集/削除ボタンの行 --}}
            <div class="comment-actions d-flex align-items-center">
                {{-- TODO: コメントへのリアクション（後日実装） --}}
                <div class="comment-action-icons ml-auto">
                    {{-- 返信（ログイン中のみ） --}}
                    @auth
                        <button class="icon-reply" type="button" data-toggle="collapse"
                            data-target="#reply-form-{{ $comment->id }}" aria-expanded="false"
                            aria-controls="reply-form-{{ $comment->id }}" aria-label="コメントに返信" title="返信">
                            <i class="fas fa-reply"></i>
                        </button>
                    @endauth
                    {{-- 編集・削除（コメントの投稿者のみ） --}}
                    @if (Auth::id() === $comment->user_id)
                        <div class="comment-edit-icons">
                            <button type="button" class="icon-edit" data-toggle="collapse"
                                data-target="#edit-form-{{ $comment->id }}" aria-label="コメントを編集" title="編集">
                                <i class="fas fa-pen"></i>
                            </button>
                            <form action="{{ route('comment.delete', [$post->id, $comment->id]) }}" method="POST"
                                class="js-comment-delete-form d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="icon-delete" aria-label="コメントを削除" title="削除">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            {{-- 返信フォーム --}}
            @auth
                <div class="{{ old('parent_id') == $comment->id ? 'show' : '' }} collapse"
                    id="reply-form-{{ $comment->id }}">
                    @include('comments.comment_form', ['post' => $post, 'parentId' => $comment->id])
                </div>
            @endauth
            {{-- 編集フォーム --}}
            @if (Auth::id() === $comment->user_id)
                <div class="{{ old('edit_comment_id') == $comment->id ? 'show' : '' }} collapse"
                    id="edit-form-{{ $comment->id }}">
                    @include('comments.comment_edit_form', ['post' => $post, 'comment' => $comment])
                </div>
            @endif
        </div>
    </div>

    {{-- 子コメント(返信)があれば、同じ部品で表示 --}}
    @if ($comment->children->isNotEmpty())
        <ul class="comments-list comment-replies {{ $depth < $maxIndentDepth ? 'is-indented' : '' }}">
            @foreach ($comment->children as $child)
                @include('comments.comment_item', ['comment' => $child, 'depth' => $depth + 1])
            @endforeach
        </ul>
    @endif

</li>
