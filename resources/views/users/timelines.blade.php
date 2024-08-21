@foreach ($posts as $post)
    @include('posts.show', ['user' => $user, 'post' => $post])
@endforeach
{{ $posts->links('pagination::bootstrap-4') }}
