@if (Auth::check() && Auth::id() !== ($userId ?? $following->id ?? $follower->id))
    @if (Auth::user()->isFollow($userId ?? $following->id ?? $follower->id))
        <form method="POST" action="{{ route('unfollow', $userId ?? $following->id ?? $follower->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">フォロー解除</button>
        </form>
    @else
        <form method="POST" action="{{ route('follow', $userId ?? $following->id ?? $follower->id) }}">
            @csrf
            <button type="submit" class="btn btn-success">フォローする</button>
        </form>
    @endif
@endif
