<h6 class="comment-title du-font-title mt-3">コメント</h6>
<ul class="comments-list comment-root">
    @forelse ($post->topLevelComments as $comment)
        @include('comments.comment_item', ['comment' => $comment, 'depth' => 1])
    @empty
        <li class="comment-notExist text-muted">コメントはまだありません。</li>
    @endforelse
</ul>
