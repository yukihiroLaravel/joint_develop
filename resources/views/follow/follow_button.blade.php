@if (Auth::check() && Auth::id() != $user->id)
    @if (Auth::user()->is_following($user->id))
        <form action="{{ route('unfollow', $user->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger w-100 mt-4">フォローを外す</button>
        </form>
    @else
        <form action="{{ route('follow', $user->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success w-100 mt-4">フォロー</button>
        </form>
    @endif
@endif

