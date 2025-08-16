@extends('layouts.app')
@section('content')
@include('commons.success_messages')
<div class="row">
     @include('users.profile')

    <div class="col-sm-8">
        @include('users.tabs')
        @foreach ($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <strong>{{ $post->user->name }}</strong>
                    <span class="text-muted">{{ $post->created_at->diffForHumans() }}</span>
                    <p>{{ $post->content }}</p>
                </div>
            </div>
        @endforeach

        {{ $posts->links() }}   
    </div>
</div>
@endsection