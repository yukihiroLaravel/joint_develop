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
                        @if (Auth::check())
                            <div class="row actions">
                                <form class="d-inline-block w-100 m-1 p-1" method="POST" action="{{ route('comment.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="hidden" name="comments" />
                                        <input value="{{ $post->id }}" type="hidden" name="post_id" />
                                        <input value="{{ Auth::id() }}" type="hidden" name="user_id" />
                                        <textarea class="form-control comment-input" placeholder="コメントを投稿する ..."
                                            autocomplete="off" type="text" name="comment" rows="2" cols="40"
                                            value="{{ old('comment') }}"></textarea><br>
                                        <div class="text-left">
                                            <button type="submit" class="btn btn-primary">コメントする</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
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
                                <span class="card-text">
                                    {!!nl2br(e($comment->comment))!!}
                                </span>
                                <p class="text-muted">
                                    {{ $comment->updated_at }}
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