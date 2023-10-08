@if (Auth::check() && Auth::id() !== $user->id)
    @if (Auth::user()->isFollow($user->id))
        <form method="POST" action="{{ route('unfollow', $user->id) }}">
            @csrf
            @method('DELETE')
            <div class="mx-auto mb-3 mt-3 w-75">
                 <button type="submit" class="btn btn-danger btn-block">フォローを外す</button>
            </div>
        </form>
    @else
        <form method="POST" action="{{ route('follow', $user->id) }}">
            @csrf
            <div class="mx-auto mb-3 mt-3 w-75">
                 <button type="submit" class="btn btn-primary btn-block">フォローする</button>
            </div>
        </form>
    @endif
@endif