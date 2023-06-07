@if (Auth::check() && Auth::id() !== $followUser->id)
    @if (Auth::user()->isFollow($followUser->id))
        <form method="POST" action="{{ route('unFollow', $followUser->id) }}">
            @csrf
            @method('DELETE')
            <div class="mt-3">
                <button type="submit" class="btn btn-danger btn-block">フォロ―を外す</button>
            </div>
        </form>
    @else
        <form method="POST" action="{{ route('follow', $followUser->id) }}">
            @csrf
            <div class="mt-3">
                <button type="submit" class="btn btn-success btn-block">フォロ―する</button>
            </div>
        </form>
    @endif
@endif