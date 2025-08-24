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
            <div class="text-left d-inline-block w-75 mb-2">
                <a href="{{ route('users.show', ['id' => $post->user->id]) }}">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                </a>
                <p class="mt-3 mb-0 d-inline-block">
                    <a href="{{ route('users.show', ['id' => $post->user->id]) }}">
                        {{$post->user->name}}
                    </a>
                </p>
                @include('users.follow_button',['user'=> $post->user])
            </div>
            <div class="contaier">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{$post->content}}</p>
                    @if ($post->images->isNotEmpty())
                        <div class="mb-2">
                            @foreach ($post->images as $image)
                                <img src="{{ asset('storage/' . $image->file_path) }}" alt="{{ $image->file_name }}" style="max-width: 200px; margin-right: 10px; margin-bottom: 5px;">
                            @endforeach
                        </div>
                    @endif
                    <p class="text-muted">{{$post->created_at}}</p>
                </div>
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
                <div class="mt-3 text-left w-75 m-auto">
                    @if($post->replies->isNotEmpty())
                        <ul class="list-unstyled">
                            @foreach($post->replies as $reply)
                                <li class="mb-2 border p-2 rounded d-flex align-items-center">
                                    <a href="{{ route('users.show', ['id' => $reply->user->id]) }}">
                                        <img class="mr-2 rounded-circle" src="{{ Gravatar::src($reply->user->email, 40) }}" alt="ユーザのアバター画像">
                                    </a>
                                    <div>
                                        <strong>
                                            <a href="{{ route('users.show', ['id' => $reply->user->id]) }}">
                                                {{ $reply->user->name }}
                                            </a>
                                        </strong>
                                        <span class="text-muted small ml-2">
                                            {{ $reply->created_at->format('Y-m-d H:i') }}
                                        </span>
                                        <p class="mb-1">{{ $reply->content }}</p>
                                        @if (Auth::id() === $reply->user_id)
                                            <form action="{{ route('replies.delete', $reply->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">削除</button>
                                            </form>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if(Auth::check())
                        <form method="POST" action="{{ route('replies.store', $post->id) }}">
                            @csrf
                            <div class="form-group">
                                <textarea name="content" class="form-control" rows="2" placeholder="返信を書く..."></textarea>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-sm btn-secondary">返信する</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
@endif