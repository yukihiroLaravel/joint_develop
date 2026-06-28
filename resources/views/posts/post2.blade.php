<div class="posts mt-5 text-center">
    @foreach ($posts as $post)             
                <div class="post text-left d-inline-block w-75">
                    ＠{{ $post->user->name }}
                    <p>
                        @if (isset($post->content))
                            {{ $post->content }}
                        @endif
                    </p>
                </div>
    @endforeach
</div>
{{ $posts->links('pagination::bootstrap-4') }}