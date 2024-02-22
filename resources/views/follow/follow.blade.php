@if (Auth::check() && Auth::id() !== $userId)
    @if (Auth::user()->isFollowed($userId))
        <form method="POST" action="{{ route('unfollow', $userId) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">フォロー解除</button>
        </form>
    @else
        <form method="POST" action="{{ route('follow', $userId) }}">
            @csrf
            <button type="submit" class="btn btn-success">フォローする</button>
        </form>
    @endif
@endif