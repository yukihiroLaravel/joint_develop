@extends('layouts.app')
@section('content')
<h2 class="mt-5">投稿を編集する</h2>
<ul class="alert alert-danger" role="alert">
    <li class="ml-4">投稿は、必ず指定してください。</li>
</ul>
    <form method="POST" action="{{ route('post.update', $post->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group mt-5">
            <div class="form-group">
                <textarea id="content" class="form-control" name="text" rows="6">{{ old('text', $post->text) }}</textarea>
            </div>        
            <button type="submit" class="btn btn-primary">更新する</button>
        </div>
    </form>
@endsection
