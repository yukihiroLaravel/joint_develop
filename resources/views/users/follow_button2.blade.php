@if (Auth::check() && Auth::id() !== $follower->id)
    @if (Auth::user()->isFollow($follower->id))
        <form method="POST" action="{{ route('unFollow', $follower->id) }}" class="d-inline-block ml-4">
            @csrf
            @method('DELETE')
            <div class="mt-3">
                <button type="submit" class="btn btn-danger btn-block">フォロ―を外す</button>
            </div>
        </form>
    @else
        <form method="POST" action="{{ route('follow', $follower->id) }}" class="d-inline-block ml-4">
            @csrf
            <div class="mt-3">
                <button type="submit" class="btn btn-success btn-block">フォロ―する</button>
            </div>
        </form>
    @endif
@endif