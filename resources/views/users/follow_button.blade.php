@if (Auth::check() && Auth::id() !== $user->id)
    @if (Auth::user()->isFollow($user->id))
        <form method="POST" action="{{ route('unFollow', $user->id) }}">
            @csrf
            @method('DELETE')
            <div class="mt-3">
                <button type="submit" class="btn btn-danger btn-block">フォロ―を外す</button>
            </div>
        </form>
    @else
        <form method="POST" action="{{ route('follow', $user->id) }}">
            @csrf
            <div class="mt-3">
                <button type="submit" class="btn btn-success btn-block">フォロ―する</button>
            </div>
        </form>
    @endif
@endif