<ul class="list-unstyled">
    <li class="mb-3 text-center">
        <div class="text-left d-inline-block w-75 mb-2">
            @if (isset($post->user->profile_image) && $post->user->profile_image)
                <img class="rounded-circle img-fluid" style="max-width: 70px; height: auto;" src="{{ asset('storage/images/' . $post->user->profile_image) }}" alt="ユーザーのプロフィール画像">
            @else
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
            @endif
            <p class="mt-3 mb-0 d-inline-block">
                <a href="{{ route('users.show', $post->user->id) }}">{{ $post->user->name }}</a>
            </p>
        </div>
        <div class="text-left d-inline-block w-75">
            @if ($post->replies->count() > 0)
                <a href="{{ route('replies.index', $post->id) }}">リプライ{{ $post->replies->count() }}件をすべて見る</a>
            @endif
            <p class="text-muted">{{ $post->created_at }}</p>
        </div>
    </li>
</ul>