<ul class="list-unstyled">
    @foreach ($posts as $post)
        <li class="mb-3 text-center">
            <div class="d-inline-block w-75 mb-2 text-left">
                <img class="rounded-circle mr-2" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="d-inline-block mb-0 mt-3"><a href="{{ route('users.show', $post->user->id) }}">{{ $post->user->name }}</a></p>
            </div>
            <div class="">
                <div class="d-inline-block w-75 text-left">
                    <p class="mb-2">{{ $post->content }}</p>
                    <p class="text-muted">{{ $post->created_at }}</p>
                </div>
                <div class="d-flex justify-content-between w-75 m-auto pb-3">
                    @if (Auth::id() === $post->user_id)
                        <form method="" action="">
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="" class="btn btn-primary">編集する</a>
                    @endif
                </div>
            </div>
        </li>
    @endforeach
</ul>
<div class="m-auto" style="width: fit-content">{{ $posts->links('pagination::bootstrap-4') }}</div>
