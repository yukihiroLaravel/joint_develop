@if (Auth::check() && Auth::id() !== $post->user_id)
    @if (Auth::user()->isFavorite($post->id))
        <form method="POST" action="{{ route('unfavorite', $post->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">いいね！を外す</button>
        </form>
    @else
        <form method="POST" action="{{ route('favorite', $post->id) }}">
            @csrf
            <button type="submit" class="btn btn-success btn-sm">いいね！を押す</button>
        </form>
    @endif
@endif