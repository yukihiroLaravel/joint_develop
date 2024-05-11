<div class="conteiner"><!-- コンテナを使って全要素をラップしてスタイルを整えた -->
        @if (session('alertMessage'))<!-- ユーザー退会後のフラッシュメッセージの実装 -->
                <div class="alert alert-danger text-center mx-auto w-75 mb-3">
                        {{ session('alertMessage') }}
                </div>
        @elseif (session('info'))<!-- 投稿編集後のフラッシュメッセージの実装 -->
                <div class="alert alert-success text-center mx-auto w-75 mb-3">
                        {{ session('info') }}
                </div>
        @elseif (session('success'))<!-- 投稿削除後のフラッシュメッセージの実装 -->
                <div class="alert alert-danger text-center mx-auto w-75 mb-3">
                        {{ session('success') }}
                </div>        
        @endif
        <ul class="list-unstyled">           
                @foreach ($posts as $post)
                <li class="mb-3 text-center">
                        <div class="text-left d-inline-block w-75 mb-2">
                        <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                        <p class="mt-3 mb-0 d-inline-block"><a href="#">{{ $post->user->name }}</a></p>
                        <p>{{ $post->content }}</p>
                        <p>{{ $post->created_at }}</p>
                        </div>
                        <div class="d-flex justify-content-between w-75 pb-3 m-auto"> 
                                @if (Auth::id() === $post->user_id)
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
        <div class="mx-auto" style="width: fit-content">
        {{ $posts->links('pagination::bootstrap-4') }}
        </div>
</div>