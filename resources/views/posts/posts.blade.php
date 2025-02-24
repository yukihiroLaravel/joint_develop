{{-- リプライ成功時のアラート --}}
<div id="reply-alert" class="alert alert-success text-center" style="display: none; position: fixed; top: 50px; left: 50%; transform: translateX(-50%); z-index: 1000;">
    リプライが追加されました！
</div>
@if ($posts->isEmpty())
    <p>投稿がありません</p>
    @else
    <ul class="list-unstyled">
    @foreach($posts as $post)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">

                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->user_id) }}">{{ $post->user->name }}</a></p>
            </div>
            <div class="">
                <div class="text-left d-inline-block w-75">
                    <a href="{{ route('reply.index', $post->id) }}" class="text-dark text-decoration-none">
                        <p class="mb-2">{{ $post->content }}</p>
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="投稿画像" class="img-fluid mt-2" style="width: 300px; height: 200px; object-fit: cover;">
                        @endif
                        <p class="text-muted mb-0">
                            @if ($post->created_at)
                                {{ $post->created_at->format('Y-m-d H:i') }}
                            @else
                                日付なし
                            @endif</p>
                        <hr class="m-0">	
                    </a>
                    <p class="mb-0 reply">
                        <a class="text-dark text-decoration-none" href="javascript:void(0);" id="reply-button-{{ $post->id }}" data-toggle="tooltip" title="Reply">
                            <i class="far fa-comment-dots fa-lg"></i>
                            <span id="reply-count-{{ $post->id }}">{{ $post->replies->count() }}</span>
                        </a>
                        <form method="POST" action="{{ route('reply.store', $post->id) }}" class="d-inline-block w-75 hidden" id="reply-form-{{ $post->id }}">
                            @csrf
                            <div class="form-group">
                                <textarea class="form-control" name="content" rows="2" placeholder="ここに返信内容を入力..." id="textarea-{{ $post->id }}"></textarea>
                                <div class="text-right mt-3">
                                    <button type="button" class="btn btn-outline-secondary ml-2" id="cancel-button-{{ $post->id }}">キャンセル</button>
                                    <button type="submit" class="btn btn-outline-success">返信する</button>
                                </div>
                            </div>                    
                        </form>
                    </p>
                </div>

            @if (Auth::id() === $post->user_id)
                <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                    <form action="{{ route('post.delete', $post->id) }}" method="POST" onsubmit="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background-color: #dc3545; color: white;">削除</button>
                    </form>
                    <a href="{{route('post.edit',$post->id)}}" class="btn" style="background-color: #0078ba; color: white;">編集する</a>
                </div>
            @endif
            </div>
        

        </li>
    @endforeach
    </ul>
@endif

<div class="m-auto" style="width: fit-content">
{{ $posts->links('pagination::bootstrap-4') }}
</div> 
<!-- ページネーション追加 -->

{{-- リプライ投稿処理 --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const replyAlert = document.getElementById('reply-alert');
        console.log(replyAlert);

        @foreach($posts as $post)
            const replyButton{{ $post->id }} = document.getElementById('reply-button-{{ $post->id }}');
            const replyForm{{ $post->id }} = document.getElementById('reply-form-{{ $post->id }}');
            const cancelButton{{ $post->id }} = document.getElementById('cancel-button-{{ $post->id }}');
            const textarea{{ $post->id }} = document.getElementById('textarea-{{ $post->id }}');
            const replyCount{{ $post->id }} = document.getElementById('reply-count-{{ $post->id }}');
            var isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
            var loginUrl = "{{ route('login') }}";

            if (replyButton{{ $post->id }} && replyForm{{ $post->id }} && cancelButton{{ $post->id }} && textarea{{ $post->id }} && replyCount{{ $post->id }}) {
                // コメントアイコンをクリックした時、返信用formを表示・非表示する
                replyButton{{ $post->id }}.addEventListener('click', function(event) {
                    replyForm{{ $post->id }}.classList.toggle('hidden');
                });

                // キャンセルボタンをクリックした時、フォームを隠す
                cancelButton{{ $post->id }}.addEventListener('click', function() {
                    replyForm{{ $post->id }}.classList.add('hidden');
                    textarea{{ $post->id }}.value = '';
                });

                // 返信するボタンをクリックした時、form送信前にログインチェックする
                replyForm{{ $post->id }}.addEventListener('submit', function(event) {
                    if (!isLoggedIn) {
                        event.preventDefault();
                        var currentUrl = window.location.href;
                        sessionStorage.setItem('previousUrl', currentUrl);
                        const confirmRedirect = confirm('ログインが必要です。ログインページに移動しますか？');
                        if (confirmRedirect) {
                            window.location.href = loginUrl;
                        } else {
                            replyForm{{ $post->id }}.classList.add('hidden');
                            textarea{{ $post->id }}.value = '';
                            return;
                        }
                    } else {
                        // ログイン確認できたら、バリデーションチェック
                        const content = textarea{{ $post->id }}.value.trim();
                        if (content === '') {
                            event.preventDefault();
                            alert('返信内容を入力してください（空白や改行のみは無効です）。');
                        } else {
                            const formData = new FormData(replyForm{{ $post->id }});
                            fetch(replyForm{{ $post->id }}.action, {
                                method: 'POST',
                                body: formData,
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status) {
                                    // リプライ投稿成功時、リプライ数を更新し返信用formを隠す
                                    replyCount{{ $post->id }}.textContent = data.reply_count;
                                    replyForm{{ $post->id }}.classList.add('hidden');
                                    textarea{{ $post->id }}.value = '';

                                    // アラートを表示
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
                                } else {
                                    // バリデーションエラーメッセージダイアログ
                                    alert(data.errors.content[0]);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('リプライの投稿に失敗しました。');
                            });
                            event.preventDefault();
                        }
                    }
                });
            }
        @endforeach
    });
</script>
