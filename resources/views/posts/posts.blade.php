<ul class="list-unstyled">
    @foreach ($posts as $post)
        <li class="media mb-3">
            <img class="mr-2 rounded" src="{{ Gravatar::src($post->user->email, 50) }}" alt="">
            <div class="media-body">
                <p class="mb-0">{{ $post->user->name }}</p>
                <p class="mb-0">{!! nl2br(e($post->content)) !!}</p>
                <div>
                    <span class="text-muted">posted at {{ $post->created_at }}</span>
                </div>
            </div>
        </li>
    @endforeach
</ul>
{{ $posts->links('pagination::bootstrap-4') }}