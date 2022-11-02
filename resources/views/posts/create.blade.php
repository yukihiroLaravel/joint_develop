<div class="text-center mb-3">
    @include('commons.error_messages')
    <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
        @csrf
        <div class="form-group">
            <textarea class="form-control" name="text" placeholder="〇〇について語る">{{ old('text') }}</textarea>
            <div class="text-left mt-3">
                <button type="submit" class="btn btn-primary">投稿する</button>
            </div>
        </div>
    </form>
</div>