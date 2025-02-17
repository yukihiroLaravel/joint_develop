<ul class="list-unstyled">
    @foreach($posts as $post)
        <li class="mb-3 text-center">
            <hr class="my-4">
            @if ($post->original_post_id)
                <div class="text-left d-inline-block w-75 mb-2 text-muted" style="font-size: 13px"><i class="bi bi-arrow-repeat"></i>
                    <a class="text-muted" href="{{ route('user.show', $post->user->id) }}">{{$post->user->name}}</a> さんがリポスト
                </div>
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="{{ $post->originalPosts->user->image ? asset('storage/' . $post->originalPosts->user->image) : Gravatar::src($post->originalPosts->user->email, 55) }}" alt="ユーザのアバター画像" style="width: 55px; height: 55px; object-fit: cover; border-radius: 50%;">
                    <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->originalPosts->user->id) }}">{{$post->originalPosts->user->name}}</a></p>
                </div>
            @else
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="{{ $post->user->image ? asset('storage/' . $post->user->image) : Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像" style="width: 55px; height: 55px; object-fit: cover; border-radius: 50%;">
                    <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->user->id) }}">{{$post->user->name}}</a></p>
                </div>
            @endif
            <div class="">
                <div id="post-{{ $post->id }}">
                    <div class="text-left d-inline-block w-75">
                        <div class="mt-1 mb-3">
                            @if (!empty($post->image_path))
                                <img src="{{ asset('storage/img/' . $post->image_path) }}" alt="投稿画像" style="width: 100%;">
                            @endif

                            @if (!empty($post->video_path))
                                <video controls class="video">
                                    <source src="{{ asset('storage/videos/' . $post->video_path) }}" type="video/mp4">
                                    ご利用のブラウザは動画をサポートしていません。
                                </video>
                            @endif
                        </div>
                        <p class="mb-2" id="output">{!! nl2br($post->content) !!}</p>
                        <div class="tags-link">
                            @foreach ($post->tags as $tag)
                                <a href="{{ route('tag.show', $tag->id) }}">#{{ $tag->name }}</a>
                            @endforeach
                        </div>
                        <p class="text-muted">{{$post->created_at}}</p>
                    </div>
                    <div class="d-flex align-items-center w-75 mb-2 mx-auto">
                        <div class="mr-4">
                            @include('replies.reply_button')
                        </div>
                        @if (!$post->original_post_id)
                            <div class="mr-4">
                                @include('reposts.repost_button')
                            </div>
                        @endif
                        <div class="mr-4">
                                @include('favorite.favorite_button', ['post' => $post])
                            </div>
                        <div class="mr-4">
                            @include('bookmark.bookmark_button', ['post' => $post])
                        </div>
                    </div>
                </div>
                @if(Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="POST" action="{{ route('post.delete',$post->id)}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        @if (!$post->original_post_id)
                            <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary">編集する</a>
                        @endif
                    </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->appends(['keyword' => request()->input('keyword', '')])->links('pagination::bootstrap-4') }}</div>
