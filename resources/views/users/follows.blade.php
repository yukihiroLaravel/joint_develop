@foreach ($followUsers as $followUser)
    @php
        $lastPost = $followUser->posts()->orderBy('id', 'desc')->first();
    @endphp
    <li>
        <p>{{ $followUser->name }}</p>
        @if (isset($lastPost->content))
            <p>{{ $lastPost->content }}</p>
        @else
            <p>まだ投稿はありません。</p>
        @endif
        @php
            $user = $followUser;
        @endphp
        @include('follow.follow_button', ['user' => $user])
    </li>
@endforeach

@if ($countFollowUsers == 0)
    <li>
        <p>フォローしているユーザーがいません。</p>
    </li>
@endif
