@php
    $posts = $user->posts()->get();
@endphp
@foreach ($posts as $post)
    <li>
        <p><a href="{{ route('users.show', $post->user->id) }}">{{ $post->user->name }}</a></p>
        <p>{{ $post->content }}</p>
    </li>
@endforeach

@if ($countPosts == 0)
    <li>
        <p>フォローしているユーザーがいません。</p>
    </li>
@endif
