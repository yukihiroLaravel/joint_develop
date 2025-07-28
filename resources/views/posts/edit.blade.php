@extends('layouts.app')

@section('content')
    <h2 class="mt-5">投稿を編集する</h2>

    <!-- エラーメッセージ表示 -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('posts.update', $post->id) }}">
        @csrf

        <div class="form-group">
            <textarea id="content" class="form-control" name="content" rows="5">{{ old('content', $post->content) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
@endsection