@php
    $countFavoriteUsers = $post->favoriteUsers()->count(); 
@endphp

@if (Auth::check() && Auth::id() !== $post->user_id)
    @if (Auth::user()->isFavorite($post->id))
        {{-- いいね済み（青） --}}
        <form method="POST" action="{{ route('unfavorite', $post->id) }}" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-link p-0 text-primary d-flex align-items-center">
                いいね <i class="fas fa-thumbs-up ml-1 mr-1"></i> {{ $countFavoriteUsers }}
            </button>
        </form>
    @else
        {{-- 未いいね（グレー） --}}
        <form method="POST" action="{{ route('favorite', $post->id) }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-link p-0 text-muted d-flex align-items-center">
                いいね <i class="far fa-thumbs-up ml-1 mr-1"></i> {{ $countFavoriteUsers }}
            </button>
        </form>      
    @endif        
@else
    {{-- 未ログイン時 --}}
    <span class="text-muted d-flex align-items-center">
        いいね <i class="far fa-thumbs-up ml-1 mr-1"></i> {{ $countFavoriteUsers }}
    </span>
@endif