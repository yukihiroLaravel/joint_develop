@extends('layouts.app')

@section('content')
<div class="container w-75">
    <h2 class="mb-4">タグ: #{{ $tag->name }}</h2>

    {{-- タグ内検索フォーム --}}
    <form action="{{ route('tags.show', $tag->id) }}" method="GET" class="form-inline mb-3">
        <input type="text" 
               name="keyword" 
               class="form-control mr-2" 
               placeholder="キーワードで検索" 
               value="{{ old('keyword', $keyword) }}">
        <button type="submit" class="btn btn-success">検索</button>
    </form>

    @if($posts->isEmpty())
        <p>投稿は見つかりませんでした。</p>
    @else
        @include('posts.posts', ['posts' => $posts])
    @endif

    <div class="mt-3">
        {{ $posts->appends(request()->query())->links() }}
    </div>
</div>
@endsection