@extends('layouts.app')

@section('content')
    <h2 class="mt-5">投稿を編集する</h2>
    <form method="POST" action="{{ route('post.update', $post->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <textarea
                id="content"
                class="form-control"
                name="content"
                rows="5"
            >{{ old('content', $post->content) }}</textarea>

            @error('content')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tags">
                タグ
            </label>

            <input
                type="text"
                id="tags"
                name="tags"
                class="form-control"
                value="{{ old('tags', $post->tags->pluck('name')->implode(', ')) }}"
                placeholder="例：仕事, うっかり, 勘違い"
            >

            <small class="form-text text-muted">
                タグはカンマ区切りで3個まで、1個につき20文字以内で入力してください。
            </small>

            @error('tags')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            更新する
        </button>
    </form>
@endsection