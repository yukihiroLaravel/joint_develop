@extends('layouts.app')
@section('content')
    <h2 class="mt-5">返信を編集する</h2>
    @include('commons.error_messages')
    <form method="POST" action="{{ route('reply.update', $reply->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="form-group">
            <textarea id="reply" class="form-control" name="content" rows="5">{{ old('content', $reply->content) }}</textarea>
        </div>
        <!-- 画像を選択していれば、画像が表示される -->
        @if ($reply->image !== null)
            <img class="mb-3" src="{{ Storage::url($reply->image) }}" alt="画像投稿" style="display: block;">
        @endif
        <button type="submit" class="btn btn-primary">返信を更新する</button>
        <input class="ml-3" type="file" name="image">
    </form>
@endsection