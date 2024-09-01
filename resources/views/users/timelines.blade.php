@foreach ($posts as $post)
    @php
        $followsParam = App\User::createDefaultFollowsParam();
        $otherUserId = $user->id;
        App\User::updateFollowsParam($followsParam, $otherUserId);
    @endphp

    @include('posts.show', ['user' => $user, 'post' => $post, 'followsParam' => $followsParam])
@endforeach
{{ $posts->links('pagination::bootstrap-4') }}
