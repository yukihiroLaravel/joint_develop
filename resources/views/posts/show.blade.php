@extends('layouts.app')

@section('content')

<div class="card w-75 mx-auto mt-4">
    <div class="card-body">

        <div class="mb-3">
            <img class="rounded-circle mr-2"
                 src="{{ Gravatar::src($post->user->email, 55) }}"
                 alt="ユーザのアバター画像">

            <a href="{{ route('users.show', $post->user->id) }}">
                {{ $post->user->name }}
            </a>
        </div>

        <hr>

        <p class="text-break">
            {{ $post->content }}
        </p>

        <p class="text-muted">
            {{ $post->created_at }}
        </p>
        @include('reactions.reaction_button', ['post' => $post])
    </div>
</div>

@endsection