@foreach ($posts as $post)
    @include('posts.show', ['user' => $user, 'post' => $post])
@endforeach
