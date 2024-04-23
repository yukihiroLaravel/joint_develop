<ul class="list-unstyled">
        <li class="mb-3 text-center">
                @php
                    $posts = App\Post::orderBy('created_at', 'desc')->paginate(10);
                @endphp
                @foreach($posts as $post)
                    <div class="text-left d-inline-block w-75 mb-2">
                        <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                        <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->user->id) }}">{{ $post->user->name }}</a></p>
                    </div>
                    <div class="post-container">
                        <div class="text-left d-inline-block w-75">
                            @if ($post)
                                <!-- 投稿が存在する場合 -->
                                <p class="mb-2">{{ $post->content }}</p>
                                <p class="text-muted">{{ $post->created_at }}</p>
                            @endif
                        </div>
                        @if (Auth::check() && Auth::id() === $post->user_id)
                            <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                                <form method="POST" action="">
                                    <button type="submit" class="btn btn-danger">削除</button>
                                </form>
                                <a href="" class="btn btn-primary">編集する</a>
                            </div>
                        @endif
                    </div> 
                @endforeach
        </li>
</ul>

<div class="m-auto" style="width: fit-content">{{ $posts->links('pagination::bootstrap-4') }}</div>
