@foreach ($posts as $post)
    <ul class="list-unstyled">
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                @if($post->user->email)
                    <img class="rounded-circle img-fluid" src="{{ Gravatar::src($post->user->email, 55) }}"
                        alt="{{ $post->user->name }}アバター画像">
                    <p class="mt-3 mb-0 d-inline-block">
                        <strong>
                            <a href="{{ route('user.show', $post->user->id) }}">{{$post->user->name}}</a>
                        </strong>
                    </p>
                @endif
            </div>
            <div class="">
                <div class="text-left d-inline-block w-75">
                    <strong>
                        <p class="mb-2">{{ $post->text }}</p>
                    </strong>
                    <p class="text-muted">{{ $post->updated_at }}</p>
                </div>
                @if ($post->user->id === Auth::id() )
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="POST" action="{{ route('post.delete', $post->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="" class="btn btn-primary">編集する</a>
                    </div>
                @endif
                <div class="card text-left d-inline-block w-75 mb-2">
                    <h5 class="card-header">コメント</h5>
                    <div class="card-body">
                        @foreach ($post->comments as $comment)
                            <div class="text-left d-inline-block w-75">
                                <span>
                                    @if($comment->user->email)
                                        <img class="rounded-circle img-fluid" src="{{ Gravatar::src($comment->user->email, 30) }}"
                                            alt="{{ $comment->user->name }}アバター画像">
                                        <p class="mt-1 mb-1 d-inline-block">
                                            <a href="{{ route('user.show', $comment->user->id) }}">{{$comment->user->name}}</a>
                                        </p>
                                    @endif
                                </span><br>
                                <span class="card-text">{!!nl2br(e($comment->comment))!!}</span>
                                <p class="text-muted">
                                    {{ $comment->updated_at }}
                                    @if ($comment->user->id == Auth::id())
                                        <a class="delete-comment" data-remote="true" rel="nofollow" data-method="delete"
                                            href="/comments/{{ $comment->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <title>コメントを削除する</title>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </li>
    </ul>
@endforeach
<div class="m-auto" style="width: fit-content">
    {{ $posts->links('pagination::bootstrap-4') }}
</div>