@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-8">
   <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3"></i>Topic Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
        @if (Auth::check())
        <div class="w-75 m-auto">
            @include('commons.error_messages')
        </div>
        <div class="text-center mb-3">
            <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="4"></textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>    
                </div>          
            </form>
        </div>
        @endif
@include('posts.posts', ['posts' => $posts])
    </div>
    <aside class="col-sm-4">
        <div class="card">
            <div class="card-header bg-info text-white">いいね！ランキング</div>
            <ul class="list-group list-group-flush">
                @foreach ($ranking_posts as $rank)
                    <li class="list-group-item">
                        <small>{{ $rank->user->name }}</small><br>
                        <a href="{{ route('user.show', $rank->user->id) }}">{{ Str::limit($rank->content, 30) }}</a>
                        <span class="badge badge-pill badge-primary">{{ $rank->favorite_users_count }} いいね</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </aside>
</div>
@endsection
