@extends('layouts.app')
@section('content')
@include('commons.success_messages')
<div class="row">
     @include('users.profile')

    <div class="col-sm-8">
        @include('users.tabs')
        @foreach ($posts as $post)
            <div class="card mb-3 shadow-sm"
                 style="background:#f9f7f1; border:2px solid #8b5e3c; border-radius:15px;">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <a href="{{ route('users.show', $post->user->id) }}">
                            <img src="{{ Gravatar::src($post->user->email, 50) }}"
                                 class="rounded-circle border border-success mr-2"
                                 alt="{{ $post->user->name }}"
                                 style="width:50px; height:50px; object-fit:cover;">
                        </a>
                        <div>
                            <strong style="color:#2e5c2b;">
                                <i class="fas fa-user"></i> {{ $post->user->name }}
                            </strong><br>
                            <span class="text-muted small">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <p class="mt-2" style="white-space:pre-line;">{{ $post->content }}</p>
                    @if ($post->images->isNotEmpty())
                        <div class="mt-2 d-flex flex-wrap">
                            @foreach ($post->images as $image)
                                <img src="{{ asset('storage/' . $image->file_path) }}"
                                     alt="{{ $image->file_name }}"
                                     style="max-width:150px; height:auto; margin:5px; border-radius:8px; border:1px solid #8b5e3c;">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
        <div class="mt-3">
            {{ $posts->links() }}   
        </div>
    </div>
</div>
@endsection