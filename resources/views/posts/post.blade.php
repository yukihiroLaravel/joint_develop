<li class="mt-5 text-center">
    <div class="text-left d-inline-block w-75 mb-2">
        <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
        <p class="mt-3 mb-0 d-inline-block">
            <a href="{{ route('user.show', $post->user->id) }}">{{ $post->user->name }}</a>
        </p>
    </div>
    <div class="">
        <div class="text-left d-inline-block w-75">
            @if($post->tag)
                <p class="small text-secondary mb-1 border border-secondary rounded-sm d-inline-block p-1">
                    #{{ $post->tag->name }}
                </p>
            @endif
            
            <!-- New post content section with image -->
            <div class="post">
                <p class="mb-2">{{ $post->content }}</p>
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="投稿された画像" class="img-fluid">
                @endif
            </div>
            
            <p class="text-muted text-right">{{ $post->created_at }}</p>
        </div>
        @if (Auth::check() && Auth::id() === $post->user->id)
            <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                <form method="POST" action="{{ route('post.delete', $post->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">削除</button>
                </form>
                <a href="{{ route('post.edit', $post->id)}}" class="btn btn-primary">編集する</a>
            </div>
        @endif
    </div>
</li>
