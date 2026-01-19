<form action="{{ route('post.store') }}" method="POST" class="mt-2">
    @csrf
    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
    
    <div class="form-group mb-1">
        <textarea 
            name="content[{{ $parent_id }}]" 
            class="form-control form-control-sm" 
            rows="2" 
            placeholder="返信を入力..." 
        >{{ old("content.$parent_id") }}</textarea>

        @if($errors->has("content.$parent_id"))
            <small class="text-danger">投稿内容は140文字以内で入力してください。</small>
        @endif
    </div>

    <div class="form-group mb-1">
        <textarea 
        name="tags[{{ $parent_id }}]" 
        class="form-control form-control-sm" 
        rows="1" 
        placeholder="タグ（スペースやエンターで区切れます）"
        >{{ old("tags.$parent_id") }}</textarea>

        @if($errors->has("tags.$parent_id"))
            <small class="text-danger">タグが長すぎます（30文字以内）。</small>
        @endif
    </div>

    <div class="text-right">
        <button type="submit" class="btn btn-primary btn-sm">返信を投稿</button>
    </div>
</form>
