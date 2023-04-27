@if (Auth::check() && Auth::id() !== $user->id)
    @if (Auth::user()->isFollow($user->id))
        <form method="POST" action="{{ route('unFollow', $user->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-block">フォローを外す</button>
        </form>
    @else
        <form method="POST" action="{{ route('follow', $user->id) }}">
            @csrf
            <button type="submit" class="btn btn-success btn-block">フォローをする</button>
        </form>
    @endif
@endif