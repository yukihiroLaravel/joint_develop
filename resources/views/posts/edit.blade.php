@if(Auth::id() == $post->user_id)
<div class="d-flex justify-content-between w-75 pb-3 m-auto">
    <form method="" action="">
        <button type="submit" class="btn btn-danger">削除</button>
    </form>
    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary">編集する</a>
</div>
@endif


