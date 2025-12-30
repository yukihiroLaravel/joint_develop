<ul class="list-unstyled w-75 mx-auto">
    @foreach($posts as $post)
        <li class="mb-4">
            {{-- ユーザー情報 --}}
             <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->user->id) }}">{{$post->user->name}}</a></p>
            </div>
            <div class="">
                <div class="text-left d-inline-block w-75">
                    <!-- 投稿内容 -->
                    <p class="mb-2">{{ $post->content }}</p>
                    <!-- 画像表示 -->
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid mb-3">
                    @endif
                    <!--投稿日時（フォーマット付き）-->
                    <p class="text-muted">{{ $post->created_at->format('Y-m-d H:i') }}</p>

                    <!-- タグ表示 -->
                    @if($post->tags->isNotEmpty())
                        <div class="mt-2">
                            @foreach($post->tags as $tag)
                                <span class="mr-1">
                                    <a href="{{ route('tags.show', $tag->id) }}" class="badge badge-secondary">#{{ $tag->name }}</a>
                                    <!-- タグ解除ボタン（投稿者のみ表示） -->
                                    @if(Auth::id() === $post->user_id)
                                        <form method="POST" action="{{ route('post.tag.destroy', [$post->id, $tag->id]) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-link text-danger p-0 ml-1 mb-1">×</button>
                                        </form>
                                    @endif
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
                @if(Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="POST" action="{{ route('post.delete', $post->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="" class="btn btn-primary">編集する</a>
                    </div>
                @endif
            </div>
        </li>
    @endforeach
    <div class="m-auto" style="width: fit-content">{{ $posts->links('pagination::bootstrap-4') }}</div>
</ul>