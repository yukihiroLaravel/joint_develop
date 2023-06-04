@if (Auth::check() && Auth::id() !== $user->id)
    <div class="mt-3 w-75 mx-auto">
        @if (Auth::user()->isFollow($user->id))
            <form method="POST" action="{{ route('unfollow', $user->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-block">フォローを外す</button>
            </form>
        @else
            <form method="POST" action="{{ route('follow', $user->id) }}">
                @csrf
                <button type="submit" class="btn btn-primary btn-block">フォローする</button>
            </form>
        @endif
    </div>
@endif
