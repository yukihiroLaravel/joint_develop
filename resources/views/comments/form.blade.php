<div class="container mt-3">
    <h5 class="text-center mb-3">"投稿内容"について140字以内でコメントをしよう！</h5>
    <div class="w-75 m-auto">@include('commons.error_messages')</div>
        <div class="text-center mb-3">
            @auth
                <form method="POST" action="{{ route('comments.store') }}" class="d-inline-block w-75">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <textarea class="form-control" name="body" rows="4">{{ old('body') }}</textarea>
                        <div class="text-left mt-3">
                            <button type="submit" class="btn btn-primary">コメントする</button>
                        </div>
                    </div>
                </form>
            @endauth
        </div>
    </div>
</div>