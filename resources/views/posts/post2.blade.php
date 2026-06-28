<!-- <h2 class="mt-5 mb-5">投稿一覧</h2> -->
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