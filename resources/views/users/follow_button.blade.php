@if(Auth::check() && Auth::id() != $user->id)
    @if (Auth::user()->isFollowing($user->id))
    <form action="{{ route('unfollow', $user->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger w-100 mt-4">フォロー解除</button>
    </form>
    @else
    <form action="{{ route('follow', $user->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary w-100 mt-4">フォローする</button>
    </form>
    @endif
@endif