@extends('layouts.app')
@section('content')
<div class="container">

    <h4>画像編集</h4>

    <!-- 現在の画像 -->
    @if ($post->image)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid">
        </div>
    @endif

    <!-- 更新 -->
    <form method="POST" action="{{ route('posts.image.update', $post) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <input type="file" name="image" required>
        </div>

        <button class="btn btn-primary">画像を更新</button>
    </form>

    <!-- 削除 -->
    @if ($post->image)
        <form method="POST" action="{{ route('posts.image.destroy', $post) }}" class="mt-3">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" onclick="return confirm('画像を削除しますか？')">画像を削除</button>
        </form>
    @endif

</div>
@endsection