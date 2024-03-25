<div class="container mt-3">
    <h5 class="text-center">コメント一覧</h5>
    <div class="w-75 m-auto">
        @foreach ($post->comments as $comment)
            <div class="mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <img class="mr-2 rounded-circle" src="{{ Gravatar::src($comment->user->email, 30) }}" alt="ユーザのアバター画像">
                        <h6 class="card-title">{{ $comment->user->name }}</h6> 
                    </div>
                    <p class="card-text">{{ $comment->body }}</p>
                    <p class="card-text text-muted">{{ $comment->created_at }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>