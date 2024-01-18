<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<style>
    .icon-invert {
        color: rgb(85, 172, 47);
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-1">
            @if (Auth::check() && Auth::id() !== $post->user_id)
                @if (Auth::user()->isFavorite($post->id))
                    <form method="POST" action="{{ route('unfavorite', $post->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-icon" style="text-align: right">
                            <i class="fas fa-heart icon-invert"></i>
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('favorite', $post->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-icon" style="text-align: right;">
                            <i class="far fa-heart icon-invert"></i>
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>
</div>
