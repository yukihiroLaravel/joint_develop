<ul class="list-unstyled">
    @if ($posts->isEmpty())
        <li class="text-center text-muted py-3">投稿が見つかりませんでした。</li>
    @endif
    @foreach ($posts as $post)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="">{{ $post->user->name }}</a></p>
            </div>
            <div class="">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{ $post->content }}</p>
                    <p class="text-muted">{{ $post->created_at }}</p>
                </div>
                @if (Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                       <form method="POST" action="{{ route('posts.delete', $post->id) }}">   
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="" class="btn btn-primary">編集する</a>   {{-- 編集ルート実装後に記述 --}}
                    </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">
    {{ $posts->appends(['keyword' => $keyword])->links('pagination::bootstrap-4') }}
</div>