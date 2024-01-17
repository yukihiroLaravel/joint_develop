<ul class="list-unstyled">
    @foreach ($posts as $post)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block">
                    <a href="{{ route('user.show', $post->user->id) }}">{{$post->user->name}}</a>
                </p>
            </div>
            <div class="">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{$post->content}}</p>
                        <div class="text-left mb-3">
                            @if(isset($post->img_path))
                            <img src="{{ Storage::url($post->img_path) }}" width="25%">
                            @endif
                        </div>
                    <p class="text-muted">{{$post->created_at}}</p>
                    {{-- 返信の一覧 --}}
                    @foreach($post->replies as $reply)
                        <div class="reply">
                            <p class="mb-1">{{$reply->user->name}} さんの返信: {{$reply->reply}}</p>
                            <p class="mb-1" style="color: gray;">{{$reply->created_at}}</p>
                        </div>
                    @endforeach
                    @if(Auth::check())
                        {{-- 返信フォーム --}}
                        <form method="POST" action="{{ route('createReply', ['post_id' => $post->id]) }}">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <input type="text" name="reply_content" class="form-control d-inline-block w-75 mb-2" placeholder="返信を入力">
                            <button type="submit" class="btn btn-sm btn-success ">送信</button>
                        </form>
                    @endif
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
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">
    {{ $posts->appends(request()->query())->links('pagination::bootstrap-4') }}
</div>
