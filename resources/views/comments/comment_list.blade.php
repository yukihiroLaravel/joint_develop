@foreach($comments as $comment)
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
                        {{$comment->user->name}}
                    </a>
                </p>
                {{ $comment->updated_at->format('Y年m月d日H時i分') }}
            @endif
        </span><br>
        <span class="card-text">
            @if (isset($comment->img_path))
                <p>{!!nl2br(e($comment->comment))!!}</p>
                <img src="{{ Storage::url($comment->img_path) }}" class="mb-2" alt="">
            @else
                <p>{!!nl2br(e($comment->comment))!!}</p>
            @endif
        </span>
        <div class="flex-box  adjust-center">
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
        @if ($comment->user->id === Auth::id())
            <form method="POST" action="{{ route('comment.delete', $comment->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger my-2">
                    <i class="fas fa-trash-alt"></i> コメント削除
                </button>
            </form>
        @endif
    </div>
@endforeach