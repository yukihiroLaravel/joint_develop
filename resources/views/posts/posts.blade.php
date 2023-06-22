<ul class="list-unstyled">
    @foreach ($posts as $post)
    <li class="mb-3 text-center">
        <div class="text-left d-inline-block w-75 mb-2">
            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
            <p class="mt-3 mb-0 d-inline-block">出題：<a href="{{ route('user.show', $post->user->id) }}">{{$post->user->name}}</a>さん</p>
        </div>
        <div class="">
            <div class="text-left d-inline-block w-75">
                <p class="mb-2" style="font-size: 24px;">{{$post->text}}</p>
                <p class="text-muted">{{$post->created_at}}</p>
                <p class="mt-0 mb-4"><a href="{{ route('comment.show', $post->id) }}">このお題の回答ページ</a></p>
            </div>
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
        </div>
    </li>
    @endforeach
</ul>

<div class="m-auto" style="width: fit-content">{{ $posts->links('pagination::bootstrap-4') }}</div>