@extends('layouts.app')

@section('content')
    <div class="text-center mt-5 mb-4">
        <h2>
          <span
              class="badge"
              style="background-color: #97b7a4; color: #ffffff;"
          >
              #{{ $tag->name }}
          </span>
          の投稿一覧
        </h2>

        <a href="{{ url('/') }}">
            トップページへ戻る
        </a>
    </div>

    @include('posts.posts', [
        'posts' => $posts,
        'reactionTypes' => $reactionTypes,
    ])
@endsection