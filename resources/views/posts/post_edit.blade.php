@extends('layouts.app')
@section('content')
  <h2 class="mt-5">投稿を編集する</h2>
      <form method="POST" action="{{ route('posts.update', $user->id) }}">
      @csrf
      @method('PUT')
          <div class="form-group">
              <textarea id="user_id" class="form-control" name="content" rows="5" value="{{ old('content') }}"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">更新する</button>
      </form>

@endsection