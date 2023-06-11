<div class="card text-left d-inline-block w-75 mb-2">
    <h5 class="card-header">コメント</h5>
    <div class="card-body">
        @if (Auth::check())
            <div class="actions">
                @error('comment.'. $post->id)
                    <div class="alert alert-danger w-100 mb-2" role="alert">
                        {{ $message }}
                    </div>
                @enderror
                <form class="d-inline-block w-100 mb-2" method="POST" action="{{ route('comment.store') }}">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="comments" />
                        <input value="{{ $post->id }}" type="hidden" name="post_id" />
                        <input value="{{ Auth::id() }}" type="hidden" name="user_id" />
                        <textarea class="form-control @error('comment.'. $post->id) is-invalid @enderror comment-input" placeholder="コメントを投稿する ..."
                            autocomplete="off" type="text" name="comment[{{ $post->id }}]" rows="2" cols="40"
                            value="{{ old('comment.'. $post->id) }}"></textarea><br>
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