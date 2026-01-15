@extends('layouts.app')
@section('content')

@if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

<h2 class="mt-5">投稿を編集する</h2>

<form method="POST" action="{{ route('posts.update', $post->id) }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        @include('commons.error_messages')
        <textarea
            id="content"
            class="form-control"
            name="content"
            rows="5"
        >{{ old('content', $post->content) }}</textarea>
    </div>
    {{-- 現在の写真を表示 --}}
    @if($post->image_path)
        <div class="mb-3">
            <p>現在の写真：</p>
            <img src="{{ asset('storage/' . $post->image_path) }}" style="max-width: 200px;">
        </div>
    @endif

    {{-- 新しい写真を選択 --}}
    <div class="mb-3">
        <input type="file" name="image">
    </div>
    <button type="submit" class="btn btn-primary">更新する</button>
</form>
@endsection
