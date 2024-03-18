<h5 class="text-center">コメント一覧</h5>
@foreach ($comments as $comment)
    <div class="text-center">
        <div class="text-left d-inline-block w-75 mb-2">
            <div class="container">
                <div class="text-left mb-2">
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src($comment->user->email, 30) }}" alt="ユーザのアバター画像">
                    <p><a href="{{ route('user.show', $comment->user->id) }}">{{ $comment->user->name }}</a></p>
                    <p>{{ $comment->body }}</p>
                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
    </div>    
@endforeach