@if (Auth::check() && Auth::user()->id !== $user->id)
    @if (Auth::user()->isFollow($user->id))
        <form method="POST" action="{{ route('unFollow', $user->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">フォローを外す</button>
        </form>
    @else
        <form method="POST" action="{{ route('follow', $user->id) }}">
            @csrf
            <button type="submit" class="btn btn-success">フォローする</button>
        </form>
    @endif
@endif
