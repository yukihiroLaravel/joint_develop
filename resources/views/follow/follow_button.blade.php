@if (Auth::check() && Auth::id() !== $user->id)
    @if (Auth::user()->isFollow($user->id))
        <form method="POST" action="{{ route('unfollow', $user->id) }}">
            @csrf
            @method('DELETE')
            <div class="text-center mb-3 mt-3">
                <button type="submit" class="btn btn-danger ">フォローを外す</button>
            </div>
        </form>
    @else
        <form method="POST" action="{{ route('follow', $user->id) }}">
            @csrf
            <div class="text-center mb-3 mt-3">
                <button type="submit" class="btn btn-success ">フォローする</button>
            </div>
        </form>
    @endif
@endif