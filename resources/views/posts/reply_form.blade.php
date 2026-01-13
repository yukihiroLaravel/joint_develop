<form action="{{ route('post.store') }}" method="POST" class="mt-2">
    @csrf
    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
    
    <div class="form-group mb-1">
        <textarea name="content" class="form-control form-control-sm" rows="2" placeholder="返信を入力..." required></textarea>
    </div>
    <div class="text-right">
        <button type="submit" class="btn btn-primary btn-sm">返信を投稿</button>
    </div>
</form>
