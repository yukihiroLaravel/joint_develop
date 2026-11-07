@extends('layouts.app')
@section('content')
    <h3 class="text-center mb-4">いいね!ランキング</h3>

    <ul class="list-unstyled w-75 mx-auto">
        @foreach ($posts as $post)
            @php $rank = $posts->firstItem() + $loop->index; @endphp
            <li class="d-flex align-items-center py-3">
                <div class="d-flex align-items-center mr-3" style="width: 110px;">
                    <span class="text-center" style="width: 30px;">
                        @if ($rank <= 3)
                            <i class="fas fa-medal fa-2x {{ ['text-warning', 'text-secondary', 'text-danger'][$rank - 1] }}"></i>
                        @endif
                    </span>
                    <span class="h5 mb-0 ml-2 text-muted text-right" style="width: 60px;">{{ $rank }}位</span>
                </div>
                <div class="mr-3 text-danger font-weight-bold text-nowrap">{{ $post->likes_count }}いいね!</div>
                <div class="flex-grow-1">
                    <div>{{ $post->content }}</div>
                    <div class="d-flex align-items-center mt-1">
                        <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 24) }}" alt="ユーザのアバター画像">
                        <small><a href="{{ route('users.show', $post->user_id) }}">{{ $post->user->name }}</a></small>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    <div class="m-auto" style="width: fit-content">
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
@endsection
