<div class="w-75 m-auto">
    @include('commons.error_messages')
</div>
<div class="text-center mb-3">
    <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
        @csrf
        <div class="form-group">
            <textarea class="form-control" name="content" rows="4"></textarea>
            <div class="text-left mt-3">
                <label for="tags" class="small text-muted">
                    <i class="fas fa-tags"></i> タグ（スペースまたはEnterで区切る）
                </label>
                {{-- IDを必ず "tags" に合わせる --}}
                <input id="tags" type="text" name="tags" class="form-control form-control-sm" 
                       placeholder="例: プログラミング Laravel" value="{{ old('tags', $tag ?? '') }}">
            </div>
            <div class="text-left mt-3">
                <label for="favorite_flag" class="mt-3">
                    <input id="favorite_flag" type="checkbox" name="favorite_flag" value="1" {{ old('favorite_flag', 1) == 1 ? 'checked' : '' }}>
                    いいね！を許可する
                </label>
                <br>
                <button type="submit" class="btn btn-primary mt-3">投稿する</button>
            </div>
        </div>          
    </form>
</div>
