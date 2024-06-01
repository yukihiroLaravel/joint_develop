<ul class="list-unstyled">
    <!-- PostsControllerから受け取った変数「$posts」から一つ一つの投稿を取り出して繰り返す -->
    @foreach ($posts as $post)
        <li class="mb-3 text-center">
            <!-- ユーザ情報 -->
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像"> <!-- アバター画像のURLを指定(アバターサービスGravatar使用) -->
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('users.show', ['id' => $post->user->id]) }}">{{ $post->user->name }}</a></p> <!-- ユーザ名と関連するリンクのhref属性に、ユーザのプロフィールページへのURLを指定 -->
                <p class="mt-4 mb-1 d-inline-block"><a href="{{ route('posts.show', ['id' => $post->id]) }}">投稿詳細</a></p> <!--  投稿詳細のURL-->
            </div>

            <!-- 投稿内容 -->
            <div class="text-left d-inline-block w-75">
                <p class="mb-2 post-content">{!! nl2br(e($post->content)) !!}</p> <!-- 投稿内容を表示（改行コード付きの変数を表示） -->
            </div>
            <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                <div class="d-flex align-items-center">
                    <p class="text-muted mb-0">{{ $post->created_at->format('Y年n月j日 G時i分') }}</p> <!-- 投稿日時を相対時間表記で表示 -->
                </div>
                <div class="d-flex align-items-center">
                    @include('favorite.favorite_button', ['post' => $post])
                    <button class="btn btn-info btn-sm mr-2">詳細(仮)</button>
                    @if (Auth::id() == $post->user->id)
                        <a href="{{ route('posts.edit', ['id' => $post->id]) }}" class="btn btn-primary btn-sm mr-2">編集</a>
                        <a class="btn btn-danger btn-sm text-light" data-toggle="modal" data-target="#deleteConfirmModal">削除</a>
                        <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4>削除確認</h4>
                                    </div>
                                    <div class="modal-body">
                                        <label>本当に削除してもよろしいでしょうか？</label>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                                        <form method="POST" action="{{ route('posts.destroy', $post->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">削除</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">
    {{ $posts->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-4') }} <!-- ページネーション -->
</div>
