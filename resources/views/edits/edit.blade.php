@extends('layouts.app')
@section('content')
    <div class="container">
        <h3 class="mb-4">投稿の編集</h3>
        
            {{-- 更新フォーム --}}
            <form method="POST" action="{{ route('posts.update', $post) }}">
                @csrf
                @method('PUT')

            {{--本文--}}
                <div class="mb-3">
                    <label class="form-label">本文</label>
                    <textarea
                        name="content"
                        class="form-control"
                        rows="5"
                    >{{ old('content', $post->content) }}</textarea>
                </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">更新</button>
            </form>

            {{-- 削除フォーム --}}
            <form action="{{ route('posts.destroy', $post) }}"
                    method="POST"
                    class="mt-3"
                    onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                @method('DELETE')
            
                <button type="submit" class="btn btn-danger">削除</button>
            </form>
        </div>
    </div>
@endsection