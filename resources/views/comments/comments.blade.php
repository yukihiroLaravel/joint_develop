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
                        <textarea class="form-control @error('comment.'. $post->id) is-invalid @enderror comment-input"
                            placeholder="コメントを投稿する ..." autocomplete="off" type="text" name="comment[{{ $post->id }}]"
                            rows="2" cols="40">{{ old('comment.'. $post->id) }}</textarea><br>
                        <div class="text-left">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-reply"></i> コメントする
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
        @foreach ($post->comments as $comment)
            <div class="text-left d-inline-block w-75 mb-2">
                <span>
                    @if($comment->user->email)
                        @if ($comment->user->profile_image === null)
                            <img class="rounded-circle img-fluid" src="{{ Gravatar::src($comment->user->email, 55) }}"
                                alt="{{ $comment->user->name }}プロフィール画像">
                        @else
                            <img class="rounded-circle" src="{{ asset('storage/images/profiles/'.$comment->user->profile_image) }}"
                                alt="{{ $comment->user->name }}プロフィール画像" width="55" height="55">
                        @endif
                        <p class="mt-1 mb-1 d-inline-block">
                            <a href="{{ route('user.show', $comment->user->id) }}">
                                <i class="fas fa-user-alt"></i> {{$comment->user->name}}
                            </a>
                        </p>
                    @endif
                </span><br>
                <span class="card-text">
                    {!!nl2br(e($comment->comment))!!}
                </span>
                <div class="flex-box  adjust-center">
                    <p class="text-muted mb-2 mr-2">{{ $comment->updated_at }}</p>
                    <i class="far fa-thumbs-up mb-2"></i>
                    <p class="badge badge-pill badge-light mb-2 mr-2">
                        @php
                            $countFavoriteCommentUsers = $comment->favoriteCommentUsers()->count();
                        @endphp
                        <span>{{ $countFavoriteCommentUsers }}</span>
                    </p>
                    <p>
                        @if (Auth::check() && Auth::id() !== $comment->user_id)
                            @if (Auth::user()->isFavoriteComments($comment->id))
                                <form method="POST" action="{{ route('unfavorite.comment', $comment->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm mb-2">いいね！を外す</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('favorite.comment', $comment->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm mb-2">いいね！を押す</button>
                                </form>
                            @endif
                        @endif
                    </p>
                </div>
                @if ($comment->user->id == Auth::id())
                    <form method="POST" action="{{ route('comment.delete', $comment->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mb-2">
                            <i class="fas fa-trash-alt"></i> コメント削除
                        </button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</div>