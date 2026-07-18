@if (Auth::check() && Auth::id() !== $user->id)
    @if (Auth::user()->isFollowing($user->id))
        <form method="POST" action="{{ route('users.unfollow', $user->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger w-100">フォローを外す</button>
        </form>
    @else
        <form method="POST" action="{{ route('users.follow', $user->id) }}">
            @csrf
            <button type="submit" class="btn btn-success w-100">フォローする</button>
        </form>
    @endif
@endif