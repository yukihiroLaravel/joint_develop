@extends('layouts.app')
@section('content')
  @include('commons.error_messages')
  <form method="POST" action="{{ route('post.store', $post->id) }}">
    @csrf
    @method('POST')
    <div class="form-group">
      <textarea id="content" class="form-control" name="content" rows="4">{{ old('content', $post->content) }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary" >投稿する</button>
  </form>
@endsection
