<div class="container"><!-- コンテナを使って全要素をラップしてスタイルを整えた -->
    <ul class="list-unstyled">
        
        <div class="d-flex justify-content-center">
            <form method="get" action="{{ route('posts.index') }}" class="d-inline-block w-75 mx-auto">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="検索" value="{{ request()->input('keyword') }}" autocomplete="on">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-success">検索</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @foreach ($posts as $post)
            <li class="mb-3">
                <div class="row">
                    <div class="col-5 w-75">
                        <div class="text-left d-inline-block mb-2">
                            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                            <p class="mt-3 mb-0 d-inline-block">
                                <a href="{{ route('user.show', ['id' => $post->user->id]) }}">{{ $post->user->name }}</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-7 text-right">
                        @include('follow.follow_button', ['user' => $post->user])
                    </div>
                </div>
                <p>{{ $post->content }}</p>
                <p>{{ $post->created_at }}</p>
                
                @if (Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="POST" action="{{ route('post.delete', $post->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary">編集する</a>
                    </div>
                @endif
            </li>
        @endforeach
        
    </ul>

    <div class="m-auto" style="width: fit-content">
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
</div>
