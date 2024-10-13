@if ($posts->isNotEmpty())
    @foreach ($posts as $post)
        @php
            $user = $post->user;
            //「$followsParam」を作成する。
            $followsParam = $viewHelper->createFollowsParam($user);
        @endphp
        @include('posts.show', ['user' => $user, 'post' => $post, 'followsParam' => $followsParam])
    @endforeach
    <div class="m-auto" style="width: fit-content">
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
@else
    <h5 class="text-center mt-5">{{ $viewHelper->getSearchNotFoundString() }}</h5>
@endif
