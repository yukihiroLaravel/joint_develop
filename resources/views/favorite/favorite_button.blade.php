@if (Auth::check() && Auth::id() !== $movie->user_id && $movie->favorite_flag)
    @if (Auth::user()->isFavorite($movie->id))
        <form method="POST" action="{{ route('unfavorite', $movie->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">いいね！を外す</button>
        </form>
    @else
        <form method="POST" action="{{ route('favorite', $movie->id) }}">
            @csrf
            <button type="submit" class="btn btn-success">いいね！を押す</button>
        </form>
    @endif
@endif