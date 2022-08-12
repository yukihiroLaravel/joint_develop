@if (Auth::check())
    @if (Auth::id() != $user->id)
        @if (Auth::user()->is_following($user->id))
            <form action="{{ route('unfollow', $user->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mt-4 w-100">フォローを外す</button>
            </form>
        @else
            <form action="{{ route('follow', $user->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success mt-4 w-100">フォロー</button>
            </form>
        @endif
    @endif
@endif

