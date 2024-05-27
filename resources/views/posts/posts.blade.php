<ul class="list-unstyled">
    <!-- PostsControllerから受け取った変数「$posts」から一つ一つの投稿を取り出して繰り返す -->
    @foreach ($posts as $post)
        <li class="mb-3 text-center">
            <!-- ユーザ情報 -->
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像"><!-- アバター画像のURLを指定(アバターサービスGravatar使用) -->
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('users.show', ['id' => $post->user->id]) }}">{{ $post->user->name }}</a></p><!-- ユーザ名と関連するリンクのhref属性に、ユーザのプロフィールページへのURLを指定 -->
                <p class="mt-4 mb-1 btn btn-warning"><a href="{{ route('posts.show', ['id' => $post->id]) }}">投稿詳細</a></p><!--  投稿詳細のURL-->
            </div>
            <!-- 投稿内容 -->
            <div class="">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2 post-content">{{ $post->content }}</p><!-- 投稿内容を表示 -->
                    <p class="text-muted">{{ $post->created_at }}</p><!-- 投稿日時を相対時間表記で表示 -->
                </div>
                @if (Auth::id() == $post->user->id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="{{ route('posts.edit', ['id' => $post->id]) }}" class="btn btn-primary">編集する</a>
                    </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->appends(request()->query())->links('pagination::bootstrap-4') }}</div><!-- ページネーション機能追記 -->
