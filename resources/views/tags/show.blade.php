@extends('layouts.app')
@section('content')
<div class="container">
    <h3 class="mb-4">
        タグ：#{{ $tag->name }}
    </h3>


    @include('posts.posts', ['posts' => $posts])
    {{ $posts->links() }}
</div>
@endsection