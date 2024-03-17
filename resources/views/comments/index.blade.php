<h5 class="mt-5">コメント一覧</h5>
<ul>
    @foreach ($comments as $comment)
        <li>{{ $comment->body }}</li> 
    @endforeach
</ul>