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
        <!-- 画像投稿 -->
        <div class="d-flex flex-column flex-md-row align-items-md-end mb-3">
            <div class="du-image-column">
                <div class="form-group mt-2">
                    <label for="image" class="mb-0"><i class="fas fa-image mr-1"></i>画像を追加(任意)</label>
                    <input type="file" class="du-btn-plain" name='image' id="image">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
    @endsection
