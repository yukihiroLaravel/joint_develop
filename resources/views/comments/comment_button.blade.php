@if (Auth::check())
    <div class="d-flex justify-content-end w-75 m-auto">
        <a href="{{ route('comment.create', $post->id) }}" class="btn btn-success">コメントする</a>
    </div>
@endif