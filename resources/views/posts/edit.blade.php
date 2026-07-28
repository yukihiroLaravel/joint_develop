    @extends('layouts.app')
    @section('content')
    <h2 class="mt-5">投稿を編集する</h2>
    @include('commons.error_messages')
    <form method="POST" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class=" form-group">
            <textarea id="content" class="form-control" name="content" rows="4">{{ old('content', $post->content) }}</textarea>
        </div>
        <!-- 画像アップロード -->
        @if ($post->image !== null)
        <div class="mb-2">
            <img class="img-fluid rounded post-image" src="{{ asset('storage/' . $post->image) }}" alt="投稿画像">
        </div>
        <div class="form-group mt-2">
            <label for="image" class="mb-1 d-inline"><i class="fas fa-image mr-1"></i>画像を変更</label>
            <input type="file" name="image" id="image" class="file-image-input">
            <button type="button" id="image-clear" class="btn btn-light d-none btn-outline-secondary btn-sm btn-small">×解除</button>
            <div class="form-group mt-2">
                <label for="delete_image" class="mb-1 d-inline bg-primary-subtle text-danger"><i class="fas fa-image mr-1 "></i><span class="text-danger">画像を削除</span></label>
                <input type="checkbox" name="delete_image" id="delete_image">
            </div>
        </div>
        @else
        <div class="form-group mt-2">
            <label for="image" class="mb-1 d-block "><i class="fas fa-image mr-1"></i>画像を追加(任意 2MBまで)</label>
            <input type="file" name="image" id="image" class="file-image-input">
            <button type="button" id="image-clear" class="btn btn-light d-none btn-outline-secondary btn-sm btn-small">×解除</button>
        </div>
        @endif
        <button type=" submit" class="btn btn-primary">更新する</button>
    </form>
    @endsection
