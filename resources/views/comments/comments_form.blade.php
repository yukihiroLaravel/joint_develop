@auth
    <div class="comment-form-section mt-4">
        {{-- <hr> --}}
        {{-- <h6>コメントする</h6> --}}
        <form method="POST" action="{{ route('comment.store', $post->id) }}">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $parentId }}">
            <div class="form-group">
                <input type="text" name="content" class="form-control comment-input" placeholder="コメントを入力" value="{{old('parent_id') == $parentId ? old('content') : '' }}">
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit"
                    class="btn d-flex justify-content-end du-btn-primary du-btn-link btn-comment">コメント投稿</button>
            </div>
        </form>
    </div>
@endauth
