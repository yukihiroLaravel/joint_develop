@foreach ($followerUsers as $followerUser)
    @php
        $lastPost = $followerUser->posts()->orderBy('id', 'desc')->first();
    @endphp
    <li>
        <p>{{ $followerUser->name }}</p>
        @if (isset($lastPost->content))
            <p>{{ $lastPost->content }}</p>
        @else
            <p>まだ投稿はありません。</p>
        @endif
        @php
            $user = $followerUser;
        @endphp
        @include('follow.follow_button', ['user' => $user])
    </li>
@endforeach
@if ($countFollowerUsers == 0)
    <li>
        <p>フォロワーがいません。</p>
    </li>
@endif
