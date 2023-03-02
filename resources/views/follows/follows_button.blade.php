@if(Auth::check() && Auth::id() !== $user->id)
    @if (Auth::user()->isFollow($user->id))
        <form method="post" action="{{ route('unFollow', $user->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="mt-1 w-100 btn btn-danger">フォローを外す</button>
        </form>
        @else
        <form method="post" action="{{ route('follow', $user->id) }}">
            @csrf
            <button type="submit"  class="mt-1 w-100 btn btn-success">フォローする</button>
        </form>
    @endif
@endif