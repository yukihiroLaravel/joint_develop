@if (Auth::id() != $post->user->id)
    @if (Auth::check())
        <div class="d-flex justify-content-end w-75 m-auto">
            <a href="{{ route('new.comment', $post->id) }}" class="btn btn-success">コメントする</a>
        </div>
    @endif
@endif