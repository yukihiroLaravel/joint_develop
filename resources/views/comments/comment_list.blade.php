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
                {{ $comment->updated_at->format('Y年m月d日H時i分') }}
            @endif
        </span><br>
        <span class="card-text">
            {!!nl2br(e($comment->comment))!!}
        </span>
        @if ($comment->user->id == Auth::id())
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