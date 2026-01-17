@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">いいねランキング</h2>

    @foreach($posts as $post)
        <div class="border p-3 mb-3">

            {{-- 順位 --}}
            <h5>
                @if ($loop->iteration === 1)
                    🥇 1位
                @elseif ($loop->iteration === 2)
                    🥈 2位
                @elseif ($loop->iteration === 3)
                    🥉 3位
                @else
                    {{ $loop->iteration }} 位
                @endif
            </h5>

            <p class="mb-1">
                <a href="{{ route('user.show', $post->user->id) }}">
                    {{ $post->user->name }}
                </a>
            </p>

            <p>{{ $post->content }}</p>

            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid mb-2">
            @endif

            <span class="badge badge-danger">
                ❤️ {{ $post->like_users_count }}
            </span>
        </div>
    @endforeach

    {{ $posts->links() }}
</div>
@endsection
