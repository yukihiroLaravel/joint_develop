<h5 class="mt-5">コメント一覧</h5>
<ul>
    @foreach ($comments as $comment)
        <li>
            {{ $comment->body }}
            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
        </li>
    @endforeach
</ul>