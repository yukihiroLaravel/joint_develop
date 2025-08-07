@if ($posts->count())
    @include('posts.posts', ['posts' => $posts])
    <div class="mt-3">{{ $posts->appends(['tab' => 'timeline'])->links() }}</div>
@else
    <p>投稿はありません。</p>
@endif
