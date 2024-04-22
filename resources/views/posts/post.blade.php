<div class="">
    <div class="text-left d-inline-block w-75">
        <p class="mb-2">{{ $post->content }}</p>
        <p class="text-muted">{{ $post->created_at }}</p>
    </div>
    @if (Auth::check() && Auth::id() === $user->id)
    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
        <form method="" action="">
            <button type="submit" class="btn btn-danger">削除</button>
        </form>
        <a href="" class="btn btn-primary">編集する</a>
    </div>
    @endif
</div>