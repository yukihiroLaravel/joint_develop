<ul class="list-unstyled">
    @foreach ($comments as $comment)
    <li class="mb-3 text-center">
        <div class="text-left d-inline-block w-75 mb-2">
            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($comment->user->email, 35) }}" alt="ユーザのアバター画像">
            <p class="mt-3 mb-0 d-inline-block">回答：<a href="{{ route('user.show', $comment->user->id) }}">{{$comment->user->name}}</a>さん</p>
            <p class="text-muted d-inline-block ml-4">{{$comment->created_at}}</p>
        </div>
        <div class="">
            <div class="text-left d-inline-block w-75">
                @if ($comment->post)
                <p class="text-center mb-2 h4">{{$comment->post->text}}</p>
                <p class="text-center text-muted mb-2 h3">{{$comment->body}}</p>
                @endif
            </div>
            @include('favorite.comment_favorite_button', ['comment' => $comment])
            @if (Auth::id() === $comment->user_id)
            <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                <form method="POST" action="{{ route('comment.delete', [$comment->post->id, $comment->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">削除</button>
                </form>
                <a href="{{ route('comment.edit', [$comment->post->id, $comment->id]) }}" class="btn btn-primary">編集する</a>
            </div>
            @endif
        </div>
    </li>
    @endforeach
</ul>