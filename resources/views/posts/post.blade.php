    @if($posts->isEmpty())
        <p>投稿はありません。</p>
    @else
        <ul class="list-unstyled">
            @foreach($posts as $post)
                <li class="mb-3 text-center">
                    
                <div class="text-left d-inline-block w-75 mb-2">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('user.show', $post->user->id) }}">
                            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                        </a>
                        <p class="mb-0 d-inline-block mr-3">
                            <a href="{{ route('user.show', $post->user->id) }}">{{ $post->user->name }}</a>
                        </p>
                        
                        {{-- いいねボタン群をユーザー名の右横へ移動 --}}
                        <div class="d-flex align-items-center ml-auto">
                            {{-- ログイン済み、かつ自分の投稿ではない場合のみボタンを表示 --}}
                            @if (Auth::check() && Auth::id() != $post->user_id)
                                @if (Auth::user()->isFavorite($post->id))
                                    {{-- すでに「いいね」している場合は「いいね解除」ボタン --}}
                                    <form method="POST" action="{{ route('unfavorite', $post->id) }}" class="mr-2 mb-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-success btn-sm">いいねを外す</button>
                                    </form>
                                @else
                                    {{-- まだ「いいね」していない場合は「いいね」ボタン --}}
                                    <form method="POST" action="{{ route('favorite', $post->id) }}" class="mr-2 mb-0">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success btn-sm">いいね！</button>
                                    </form>
                                @endif
                            @endif
                            
                            {{-- いいね数の表示（全員共通） --}}
                            <a href="{{ route('post.favorites', $post->id) }}" class="badge badge-pill badge-success">いいね数 {{ $post->favoriteUsers()->count() }}</a>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="text-left d-inline-block w-75">
                        <p class="mb-2">{{ $post->content }}</p>
                        <p class="text-muted">
                        @if($post->created_at)
                            {{ $post->created_at->format('Y/m/d H:i:s') }}
                        @else
                            日付未設定
                        @endif
                        </p>

                    </div>
                    @if (Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="POST" action="{{ route('post.destroy', $post->id) }}">
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
        </ul>
    @endif