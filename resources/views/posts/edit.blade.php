@extends('layouts.app')
@section('content')
@include('replies.partials_show', ['post' => $post])
<div class="text-center mb-3">
    <div class="w-75 m-auto">
        @include('commons.error_messages')
    </div>
    <form method="post" action="{{ route('post.update', ['id' => $id]) }}" class="d-inline-block w-75">
        @csrf
        @method('PUT')
        <div class="form-group text-left">
            <label for="content">投稿編集</label>
            <p>YouTube動画のURLが<span>https://www.youtube.com/watch?v=-bNMq1Nxn5o</span>ならば、
                <br>"v="の直後にある<span class="text-success">-bNMq1Nxn5o</span>を入力</p>
            <input name="youtube_id" id="youtube_id" class="form-control"  required value="{{ old('youtube_id', $post->youtube_id) }}">
            <textarea name="content" id="content" class="form-control" rows="4" required>{{ old('content', $post->content) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary float-right">更新</button>
    </form>
</div>
@endsection