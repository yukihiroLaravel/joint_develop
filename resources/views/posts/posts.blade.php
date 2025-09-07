@if (!empty($keyword))
    <div class="w-75 m-auto">
        <p>「{{ $keyword }}」の検索結果：{{ $posts->total() }}件</p>
    </div>    
@endif
@if ($posts->isEmpty())
    <p class="text-center mt-4">検索結果はありませんでした。</p>
@else
<ul class="list-unstyled">
    @foreach ($posts as $post)
        <li class="mb-3 text-center">
            {{-- 投稿者の情報 --}}
            <div class="text-left d-inline-block w-75 mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('users.show', ['id' => $post->user->id]) }}">
                            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                        </a>
                        <p class="mb-0">
                            <a href="{{ route('users.show', ['id' => $post->user->id]) }}">
                                {{$post->user->name}}
                            </a>
                        </p>
                    </div>
                    <div>
                        @include('users.follow_button',['user'=> $post->user])
                    </div>
                </div>
            </div>
            {{-- 投稿内容 --}}
            <div class="text-left w-75 m-auto">
                <p>
                    @if (isset($post->title)) 
                        {{ $post->title }} 
                    @endif
                </p> 
                <p class="mb-2">
                    <a href="{{ route('posts.show', $post->id) }}">
                        {{ $post->content }}
                    </a>
                </p>
                @if ($post->images->isNotEmpty())
                    <div class="mb-2">
                        @foreach ($post->images as $image)
                            <img src="{{ asset('storage/' . $image->file_path) }}" alt="{{ $image->file_name }}" style="max-width: 200px; margin-right: 10px; margin-bottom: 5px;">
                        @endforeach
                    </div>
                @endif
                <p class="text-muted">{{ $post->created_at }}</p>
                {{-- いいねボタン --}}
                <div class="d-flex align-items-center">
                    @include('favorite.favorite_button', ['post' => $post])
                </div>    
                {{-- 返信件数 --}}
                <p class="text-muted small">
                    <a href="{{ route('posts.show', $post->id) }}">
                        返信 {{ $post->replies_count }} 件
                    </a>
                </p>
            </div>
                {{-- 投稿の編集・削除 --}}
                @if (Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="POST" action="{{ route('posts.delete', $post->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">編集する</a>
                    </div>
                @endif
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
@endif