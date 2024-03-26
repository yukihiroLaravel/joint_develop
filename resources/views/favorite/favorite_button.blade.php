@if (Auth::check() && Auth::id() !== $post->user_id)
    @if (Auth::user()->isFavorite($post->id))
        <form method="POST" action="{{ route('unfavorite' ,$post->id) }}">
            @csrf
            @method('DELETE')
            <button style="border: solid 1px gray; background-color:inherit; border-radius: 3em; color:gray">いいねすみ&nbsp;<i
                class="fas fa-heart" style="color:deeppink; "></i></button>
        </form>
    @else
        <form method="POST" action="{{ route('favorite' ,$post->id) }}">
            @csrf
            <button style="border: solid 1px gray; background-color:inherit; border-radius: 3em; color:gray">いいねする&nbsp;<i
                class="far fa-heart" style="color:gray; "></i></button>
        </form>
    @endif
@endif