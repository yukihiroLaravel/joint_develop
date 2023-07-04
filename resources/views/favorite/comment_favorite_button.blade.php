<div class="text-center mb-1">
    @php
    $countFavoriteUsers = $comment->favoriteUsers()->count();
    @endphp
    <span class="badge badge-pill badge-secondary">{{ $countFavoriteUsers }}w</span>
</div>
@if (Auth::check() && Auth::id() !== $comment->user_id)
    @if (Auth::user()->isCommentFavorite($comment->id))
        <form action="{{ route('comment.unfavorite', $comment->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm">ワロタwを外す</button>
        </form>
    @else
        <form action="{{ route('comment.favorite', $comment->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-success btn-sm">ワロタw</button>
        </form>
    @endif
@endif