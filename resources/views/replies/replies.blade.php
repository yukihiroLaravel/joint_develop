@extends('layouts.app')

@section('content')
    {{-- リプライ削除モーダル --}}
    <div class="modal fade" id="deleteReplyConfirmModal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>確認</h4>
                </div>
                <div class="modal-body">
                    <label>本当に削除しますか？</label>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <form id="deleteReplyForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">削除する</button>
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column">
        {{-- リプライアラート --}}
        <div id="reply-alert" class="alert text-center"
            style="display: none; position: fixed; top: 50px; left: 50%; transform: translateX(-50%); z-index: 1000;">
        </div>
        {{-- 投稿内容 --}}
        <div class="w-75 m-auto">
            <div class="mb-0 text-center">
                <div class="p-2 text-left d-inline-block w-75 target-posts">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 65) }}" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block">
                        <a href="{{ route('user.show', $post->user_id) }}">{{ $post->user->name }}</a>
                    </p>
                </div>
                <div class="p-2 text-left d-inline-block w-75 target-posts">
                    <p class="mb-2">{{ $post->content }}</p>
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="投稿画像" class="img-fluid mt-2">
                    @endif
                    <p class="text-muted mb-0">{{ $post->created_at }}</p>
                    <hr class="m-0 mb-1">
                    <a class="text-dark text-decoration-none" href="#replyList" onclick="scrollReplyList(event)"
                        data-toggle="tooltip" title="Reply">
                        <i class="far fa-comment-dots fa-lg"></i>
                        <span id="reply-count-{{ $post->id }}">{{ $post->replies->count() }}</span>
                    </a>
                </div>
                {{-- リプライフォームの表示・非表示 --}}
                @if (Auth::check())
                    <form method="POST" action="{{ route('reply.store', $post->id) }}" class="mt-2 d-inline-block w-75"
                        id="reply-form-{{ $post->id }}">
                        @csrf
                        <div class="form-group mb-0">
                            <textarea class="form-control" name="content" rows="2" placeholder="ここに返信内容を入力..."
                                id="textarea-{{ $post->id }}"></textarea>
                            <div class="text-right mt-2">
                                <button type="button" class="btn btn-outline-secondary ml-2"
                                    id="cancel-button-{{ $post->id }}">キャンセル</button>
                                <button type="submit" class="btn btn-outline-success">返信する</button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="mt-2 d-inline-block w-75 text-right">
                        <button type="button" class="btn" style="background-color: #2E8B57; color: white;" onclick="confirmLogin()">返信する</button>
                    </div>
                @endif
            </div>

            {{-- リプライ表示 --}}
            <div class="mb-3 text-center">
                <div id="replyList" class="text-left d-inline-block w-75">
                    <h4 class="mt-2 mb-2 py-2 pl-2 border-top border-bottom border-dark">
                        リプライ一覧
                    </h4>
                </div>
            </div>
            @if ($post->replies->isEmpty())
                {{-- リプライ数が０件の場合の処理 --}}
                <div class="mb-3 text-center">
                    <div id="replyList" class="text-left d-inline-block w-75">
                        <p class="m-0 d-inline-block">
                            リプライがありません
                        </p>
                    </div>
                </div>
            @else
                {{-- リプライ数が1件以上ある場合の処理 --}}
                @foreach ($replies as $reply)
                    <div class="mb-3 text-center">
                        <div class="text-left d-inline-block w-75 mb-2 pl-2">
                            <div class="d-flex">
                                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($reply->user->email, 45) }}"
                                    alt="ユーザのアバター画像">
                                <p class="m-0 mt-2 d-inline-block">
                                    <a href="{{ route('user.show', $reply->user_id) }}">{{ $reply->user->name }}</a>
                                </p>
                                {{-- ログイン時かつ、ログインユーザのid と $replyのuser_idが同じ場合に編集・削除用アイコン表示 --}}
                                @if (Auth::check() && Auth::id() === $reply->user_id)
                                    <div class="mt-3 mb-0 d-inline-block ml-auto text-right list-group">
                                        <div class="dropdown">
                                            <button class="btn" type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <button class="dropdown-item text-center" type="button"
                                                    onclick="btnEditMode({{ $reply->id }})">編集</button>
                                                <button class="dropdown-item text-center text-danger" type="button"
                                                    data-toggle="modal" data-target="#deleteReplyConfirmModal"
                                                    onclick="setDeleteModal({{ $reply->id }})">削除</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="text-left d-inline-block w-75 pl-2">
                            <p class="mb-2" id="reply-content-{{ $reply->id }}" style="">
                                {{ $reply->content }}
                            </p>
                            {{-- 編集用フォーム --}}
                            <form method="POST" action="{{ route('reply.update', $reply->id) }}"
                                class="d-inline-block w-75 hidden" id="reply-edit-form-{{ $reply->id }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <textarea class="form-control" name="content" rows="2" id="textarea-{{ $reply->id }}">{{ $reply->content }}</textarea>
                                    <div class="text-right mt-3">
                                        <button type="button" class="btn btn-outline-secondary ml-2"
                                            id="cancel-btn-{{ $reply->id }}">キャンセル</button>
                                        <button type="submit" class="btn btn-outline-success"
                                            id="update-btn-{{ $reply->id }}">更新する</button>
                                    </div>
                                </div>
                            </form>
                            <p class="text-muted">
                                {{ $reply->updated_at }}
                                @if ($reply->updated_at != $reply->created_at)
                                    &nbsp;（編集済み）
                                @endif
                            </p>
                        </div>
                        <hr class="mt-0 mb-0 w-75">
                    </div>
                @endforeach
            @endif
        </div>

        {{-- ページネーションの表示 --}}
        <div class="m-auto" style="width: fit-content">
            {{ $replies->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const replyForm{{ $post->id }} = document.getElementById('reply-form-{{ $post->id }}');
        const cancelButton{{ $post->id }} = document.getElementById('cancel-button-{{ $post->id }}');
        const textarea{{ $post->id }} = document.getElementById('textarea-{{ $post->id }}');
        const replyCount{{ $post->id }} = document.getElementById('reply-count-{{ $post->id }}');
        var isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        const replyAlert = document.getElementById('reply-alert');

        if (isLoggedIn) {
            // キャンセルボタンをクリックしたときテキストエリアを空にする
            cancelButton{{ $post->id }}.addEventListener('click', function() {
                textarea{{ $post->id }}.value = '';
            });

            // 返信ボタンをクリック時の処理
            replyForm{{ $post->id }}.addEventListener('submit', function(event) {
                // フォーム送信前のバリデーションチェック
                event.preventDefault();
                const content = textarea{{ $post->id }}.value.trim();
                if (content === '') {
                    alert('返信内容を入力してください（空白や改行のみは無効です）。');
                    return;
                }
                const formData = new FormData(replyForm{{ $post->id }});
                fetch(replyForm{{ $post->id }}.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            // リプライ投稿成功
                            replyCount{{ $post->id }}.textContent = data.reply_count;
                            textarea{{ $post->id }}.value = '';
                            sessionStorage.setItem('showReplyAlert', 'true');
                            location.reload();
                        } else {
                            // バリデーションエラーメッセージダイアログ
                            alert(data.errors.content[0]);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('リプライの投稿に失敗しました。');
                    });
            });
        }
        // sessionStorageがtrueの場合アラート表示内容の設定
        if (sessionStorage.getItem('showReplyAlert') === 'true') {
            showAlert("リプライが追加されました！", "alert-success");
            sessionStorage.removeItem('showReplyAlert');
        } else if (sessionStorage.getItem('showEditAlert') === 'true') {
            showAlert("リプライを編集しました！", "alert-success");
            sessionStorage.removeItem('showEditAlert');
        } else if (sessionStorage.getItem('showDeleteAlert') === 'true') {
            showAlert("リプライを削除しました！", "alert-danger");
            sessionStorage.removeItem('showDeleteAlert');
        }
        // アラートメッセージ表示・非表示処理
        function showAlert(message, alertClass) {
            replyAlert.innerHTML = message;
            replyAlert.classList.remove("alert-success", "alert-danger");
            replyAlert.classList.add(alertClass);
            replyAlert.style.display = 'block';
            replyAlert.style.opacity = '1';

            // 3秒後にフェードアウト
            setTimeout(() => {
                var fadeEffect = setInterval(() => {
                    if (!replyAlert.style.opacity) {
                        replyAlert.style.opacity = '1';
                    }
                    if (replyAlert.style.opacity > '0') {
                        replyAlert.style.opacity -= '0.1';
                    } else {
                        clearInterval(fadeEffect);
                        replyAlert.style.display = 'none';
                    }
                }, 100);
            }, 3000);
        }
    });

    // 未ログイン時に返信ボタンクリックした時の処理
    function confirmLogin() {
        var currentUrl = window.location.href;
        sessionStorage.setItem('previousUrl', currentUrl);
        var loginUrl = "{{ route('login') }}";
        if (confirm("ログインが必要です。ログインページに移動しますか？")) {
            window.location.href = loginUrl;
        }
    }

    // 編集ボタンクリックした時の処理
    function btnEditMode(replyId) {
        const replyContent = document.getElementById(`reply-content-${replyId}`);
        const replyEditForm = document.getElementById(`reply-edit-form-${replyId}`);
        const cancelBtn = document.getElementById(`cancel-btn-${replyId}`);
        const updateBtn = document.getElementById(`update-btn-${replyId}`);

        // 編集フォームを表示・編集前のリプライを非表示
        replyEditForm.classList.toggle('hidden');
        replyContent.style.display = replyEditForm.classList.contains('hidden') ? 'block' : 'none';
        if (!replyEditForm.classList.contains('hidden')) {
            const textarea = document.getElementById(`textarea-${replyId}`);
            textarea.focus();
            textarea.setSelectionRange(textarea.value.length, textarea.value.length);
        }

        // キャンセルボタンをクリックした時の処理
        if (!cancelBtn.dataset.listener) {
            cancelBtn.addEventListener("click", function() {
                replyEditForm.classList.add('hidden');
                replyContent.style.display = "block";
                const textarea = document.getElementById(`textarea-${replyId}`);
                textarea.value = replyContent.textContent.trim();
            });
            cancelBtn.dataset.listener = "true";
        }

        // 更新ボタンをクリックした時の処理
        updateBtn.addEventListener("click", function(event) {
            event.preventDefault();
            const textarea = document.getElementById(`textarea-${replyId}`);
            const content = textarea.value.trim();
            if (content === '') {
                alert('返信内容を入力してください（空白や改行のみは無効です）。');
                return;
            }

            const formData = new FormData(replyEditForm);
            fetch(replyEditForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                        sessionStorage.setItem('showEditAlert', 'true');
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    } else {
                        if (data.message === 'このリプライを編集する権限がありません。') {
                            alert(data.message);
                        } else {
                            alert(data.errors.content[0]);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('リプライの編集に失敗しました。');
                });
        });
    }

    // 削除ボタンをクリックした時の処理
    function setDeleteModal(replyId) {
        var routeUrl = "{{ route('reply.delete', ':id') }}";
        routeUrl = routeUrl.replace(':id', replyId);
        document.getElementById('deleteReplyForm').action = routeUrl;
    }

    // リプライ削除確認ダイアログの削除するボタンをクリックした時の処理
    document.addEventListener('DOMContentLoaded', function() {
        const deleteReplyForm = document.getElementById('deleteReplyForm');
        if (deleteReplyForm) {
            deleteReplyForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const form = this;
                fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });
                            sessionStorage.setItem('showDeleteAlert', 'true');
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        } else {
                            if (data.message) {
                                alert(data.message);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('リプライの削除に失敗しました。');
                    });
            });
        }
    });

    // コメントアイコンクリックした時の処理
    function scrollReplyList(event) {
        event.preventDefault();
        const replyList = document.getElementById("replyList");
        const replyListTop = replyList.getBoundingClientRect().top + window.pageYOffset;
        window.scrollTo({
            top: replyListTop,
            behavior: 'smooth'
        });
    }
</script>
