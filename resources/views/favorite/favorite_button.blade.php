@if (Auth::check() && Auth::id() !== $post->user_id)
    
    @if (Auth::user()->isFavorite($post->id))
        <form action="{{ route('unfavorite', $post->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm">いいね！を外す</button>
        </form>
    @else
        <form action="{{ route('favorite', $post->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-success btn-sm">いいね！を押す</button>
        </form>
    @endif
@endif