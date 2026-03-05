@extends('layouts.app')

@section('content')
    <h2 class="mt-5 text-center">投稿を編集する</h2>
    <div class="row mt-5 mb-5">
        <div class="col-sm-6 offset-sm-3">
            @include('commons.error_messages')
            <form method="POST" action="{{ route('post.update', $post->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="4">{{ old('content', $post->content) }}</textarea>
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary">更新する</button>
                    <a href="/" class="btn btn-secondary ml-3">キャンセル</a>
                </div>
            </form>
        </div>
    </div>
@endsection
