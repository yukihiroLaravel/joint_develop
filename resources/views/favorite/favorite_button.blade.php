@if (Auth::check() && Auth::id() !== $post->user_id)
    @if (Auth::user()->isFavorite($post->id))
        <form method="POST" action="{{ route('unfavorite', $post->id) }}">
            @csrf
            @method('DELETE')
            <button class="favorite-btn hover">
                <i class="fas fa-heart"></i><i
                    class="fas fa-minus mr-2 favorite-pulus"></i>{{ $post->favoritesUser()->count() }}
            </button>
        </form>
    @else
        <form method="POST" action="{{ route('favorite', $post->id) }}">
            @csrf
            <button class="favorite-btn hover">
                <i class="far fa-heart"></i><i
                    class="fas fa-plus mr-2 favorite-minus"></i>{{ $post->favoritesUser()->count() }}
            </button>
        </form>
    @endif
@else
    <div class="favorite-btn">
        <i class="fas fa-heart mr-2"></i>{{ $post->favoritesUser()->count() }}
    </div>
@endif
