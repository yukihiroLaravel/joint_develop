@extends('layouts.app')
@section('content')
    <h2 class="mt-5">投稿を編集する</h2>
    @include('commons.error_messages')
    <form method="post" action="{{ route('posts.update', $post->id) }}">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <textarea id="content" class="form-control" name="content" rows="4" placeholder="本文を入力（例：サッカー観戦楽しかった！）">{{ old('content', $post->content) }}</textarea>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-primary">更新</button>
        </div>
    </form>
@endsection
