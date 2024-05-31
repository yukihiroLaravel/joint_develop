@if(Auth::check() && Auth::id())
    <div class="w-75 bg-light mb-2 mx-auto">
        @include('comments.comment_list')
    </div>
@endif
@if(Auth::check() && Auth::id() !== $post->user_id)
    <div class="text-center">
        <div class="d-flex w-75 pb-3 m-auto">
            <form method="POST" action="{{ route('comment.store', ['post_id' => $post->id]) }}" class="w-100 d-inline-block w-75">
                @csrf
                <div class="form-group">
                    <textarea class="form-control w-100" name="comment_{{ $post->id }}" placeholder="コメントを入力..." rows="4">{{ old('comment_' . $post->id) }}</textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-sm btn-primary">コメント登録</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif


