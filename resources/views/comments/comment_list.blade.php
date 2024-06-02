@foreach ($post->comments as $comment)
    <!-- フラッシュメッセージ -->
    <div id="flash-message-{{ $comment->id }}" class="alert" style="display: none;"></div>
    <div class="comment-container" data-comment-id="{{ $comment->id }}">
        <div class="d-flex justify-content-between m-auto" style="width: 100%;">
            <div class="w-100">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($comment->user->email, 55) }}" alt="ユーザのアバター画像">
                <a class="no-text-decoration black-color" style="font-size: 18px;" href="/users/{{ $comment->user->id }}">{{ $comment->user->name }}</a>
                <span class="ml-4" style="font-size: 18px;">{{ $comment->created_at->diffForHumans() }}</span>
                @if (Auth::check() && $comment->user && $comment->user->id == Auth::user()->id)
                    <a href="#" class="ml-4 edit-comment-link" data-comment-id="{{ $comment->id }}"><i class="fas fa-edit" style="color: #1a33ea; font-size: 20px;"></i></a>
                    <a href="#" class="ml-4 delete-comment" data-comment-id="{{ $comment->id }}"><i class="fas fa-trash-alt" style="color: #f01939; font-size: 20px;"></i></a>
                @endif
                <div class="w-100 text-left mb-2 mt-3 comment-content" data-comment-id="{{ $comment->id }}">
                    {{ $comment->comment }}
                </div>
                <form action="{{ route('comment.update', ['commentId' => $comment->id]) }}" method="POST" class="edit-comment-form d-none w-100" data-comment-id="{{ $comment->id }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <textarea id="comment_content_{{ $comment->id }}" class="form-control w-100" name="comment_content" rows="4" required>{{ $comment->comment }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">更新</button>
                    <button type="button" class="btn btn-sm btn-secondary cancel-edit">キャンセル</button>
                </form>
            </div>
        </div>
    </div>
@endforeach

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .comment-container {
        width: 100% !important;
    }
    .edit-comment-form {
        width: 100% !important;
    }
    .comment-content {
        overflow-wrap: break-word;
    }
    .alert-success, .alert-info, .alert-danger {
        margin-top: 10px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // コメント内容を一時保存するための変数
        const commentContents = {};

        document.querySelectorAll('.edit-comment-link').forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault();
                const commentId = link.getAttribute('data-comment-id');
                const contentDiv = document.querySelector(`.comment-content[data-comment-id="${commentId}"]`);
                const form = document.querySelector(`.edit-comment-form[data-comment-id="${commentId}"]`);
                // 現在のコメント内容を保存
                commentContents[commentId] = contentDiv.textContent.trim();
                contentDiv.classList.add('d-none');
                form.classList.remove('d-none');
            });
        });

        // キャンセルボタンがクリックされたときの処理
        document.querySelectorAll('.cancel-edit').forEach(button => {
            button.addEventListener('click', (event) => {
                const form = event.target.closest('.edit-comment-form');
                const commentId = form.getAttribute('data-comment-id');
                const contentDiv = document.querySelector(`.comment-content[data-comment-id="${commentId}"]`);
                // 編集前のコメント内容をフォームにセット
                form.querySelector('textarea').value = commentContents[commentId];
                contentDiv.classList.remove('d-none');
                form.classList.add('d-none');
            });
        });

        // フォーム外のクリックでキャンセルする処理
        document.addEventListener('click', (event) => {
            const target = event.target;
            if (!target.closest('.edit-comment-form') && !target.closest('.edit-comment-link')) {
                document.querySelectorAll('.edit-comment-form').forEach(form => {
                    const commentId = form.getAttribute('data-comment-id');
                    const contentDiv = document.querySelector(`.comment-content[data-comment-id="${commentId}"]`);
                    if (!form.classList.contains('d-none')) {
                        // 編集前のコメント内容をフォームにセット
                        form.querySelector('textarea').value = commentContents[commentId];
                        contentDiv.classList.remove('d-none');
                        form.classList.add('d-none');
                    }
                });
            }
        });

        // フラッシュメッセージを表示する関数
        function showFlashMessage(message, type, commentId) {
            const flashMessageElement = document.getElementById(`flash-message-${commentId}`);
            flashMessageElement.className = `alert alert-${type}`;
            flashMessageElement.textContent = message;
            flashMessageElement.style.display = 'block';
             // 3秒後にメッセージを非表示にする
            setTimeout(() => {
                flashMessageElement.style.display = 'none';
            }, 3000);
        }

        // 編集フォームが送信されたときの処理
        document.querySelectorAll('.edit-comment-form').forEach(form => {
            form.addEventListener('submit', (event) => {
                event.preventDefault();
                const commentId = form.getAttribute('data-comment-id');
                const content = form.querySelector('textarea').value;
                const characterCount = content.length;

                // 文字数をカウント
                if (characterCount > 140) {
                    showFlashMessage('コメントは140文字以内で入力してください。', 'danger', commentId);
                    return;
                }

                // Ajaxリクエスト(edit)
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                    },
                    body: JSON.stringify({
                        _method: 'PUT',
                        comment_content: content,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const contentDiv = document.querySelector(`.comment-content[data-comment-id="${commentId}"]`);
                        contentDiv.textContent = content;
                        contentDiv.classList.remove('d-none');
                        form.classList.add('d-none');
                        // 更新後、コメント内容を変数に保存
                        commentContents[commentId] = content;
                        // 編集成功メッセージを表示
                        showFlashMessage('コメントを更新しました。', 'info', commentId);
                    } else {
                        console.error('Failed to edit comment:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });

        // 削除リンクがクリックされたときの処理
        document.querySelectorAll('.delete-comment').forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault();
                const commentId = link.getAttribute('data-comment-id');
                const commentElement = document.querySelector(`.comment-container[data-comment-id="${commentId}"]`);

                // Ajaxリクエスト(delete)
                fetch(`/comments/${commentId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // コメントをDOMから削除
                    if (data.success) {
                        commentElement.remove();
                        // 削除成功メッセージを表示
                        showFlashMessage('コメントを削除しました。', 'success', commentId);
                    } else {
                        console.error('Failed to delete comment:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
