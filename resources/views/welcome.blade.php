@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="fab fa-telegram fa-lg pr-3"></i>Topic Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
    <div class="w-75 m-auto">
        @include('commons.error_messages')
        @if (session('status'))
            <div class="alert alert-success mt-3">
                {{ session('status') }}
            </div>
        @endif
    </div>
    <div class="text-center mb-3">
        <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="post" rows="3" value="{{ old('post') }}" placeholder="投稿内容を入力..." style="border: 1px solid #ddd; border-radius: 5px;"></textarea>
                <div class="form-group mt-4">
                    <label for="image" class="font-weight-bold">画像または動画を選択
                        <small class="text-muted font-weight-light">(jpeg,png,jpg,gif,mp4 最大50MB)</small>
                    </label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image" accept="image/*,video/mp4">
                            <label class="custom-file-label" for="image" data-browse="参照">ファイルを選択(ここにドロップすることもできます)</label>
                        </div>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary input-group-text" id="inputFileReset">取消</button>
                        </div>
                    </div>
                </div>
                <div class="text-left mt-4 mb-10">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" style="border-radius: 50px;">投稿する</button>
                </div>
            </div>
        </form>
        @include('posts.posts', ['posts' => $posts])
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
    <script>
        bsCustomFileInput.init();

        document.getElementById('inputFileReset').addEventListener('click', function() {
            bsCustomFileInput.destroy();
            var elem = document.getElementById('image');
            elem.value = '';
            var clone = elem.cloneNode(false);
            elem.parentNode.replaceChild(clone, elem);
            bsCustomFileInput.init();
        });
    </script>
@endsection
