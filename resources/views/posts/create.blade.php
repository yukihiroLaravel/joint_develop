{{-- @extends('layouts.app') --}}
{{-- @section('content') --}}
<h2 class="mt-5">Topicを投稿する</h2>

@if (session('status'))
    <div class="alert alert-success mt-3">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('post.store') }}">
    @csrf
    <div class="form-group mt-5">
        <div class="form-group">
            <label for="post" class="mt-3">投稿内容</label>
            <input id="post" type="text" class="form-control" name="post" value="{{ old('post') }}">
        </div>
        <button type="submit" class="btn btn-primary mt-5 mb-5">Topicを投稿する</button>
    </div>
</form>

<h2 class="mt-5">あなたの投稿済みTopic</h2>
{{-- TODO: 投稿一覧表示機能がマージされたらコメントアウトをはずして、投稿画面にも最新の投稿が表示されるようにする --}}
{{-- @include('posts.posts', ['posts' => $posts]) --}}
{{-- @endsection --}}