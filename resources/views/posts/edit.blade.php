@extends('layouts.app')
@section('content')
<h2 class="mt-5">投稿を編集する</h2>
    @include('commons.error_messages')
    <form method="POST" action="{{ route('posts.update', $post->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <textarea id="content" class="form-control" name="content" rows="5">{{ old('content',$post->content) }}</textarea>
        </div>
        <div class="form-group">
            <label for="tags" class="small text-muted">
                <i class="fas fa-tags"></i> タグ（×で削除 / Enterで追加 / ダブルクリックで編集）
            </label>
            
            {{-- 普通のinputとして配置。値は今まで通りスペース区切りの文字列を渡すだけ --}}
            <input id="tags" name="tags" class="form-control" 
                value="{{ old('tags', $post->tags->pluck('name')->implode(' ')) }}">
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">更新する</button>
            <a href="/" class="btn btn-light ml-2">キャンセル</a>
        </div>
    </form>
@endsection
