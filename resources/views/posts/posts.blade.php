@foreach ($posts as $post)
    <ul class="list-unstyled">
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                @if (isset($post->user->profile_image) && $post->user->profile_image)
                    <img class="rounded-circle img-fluid" style="max-width: 70px; height: auto;" src="{{ asset('storage/images/' . $post->user->profile_image) }}" alt="ユーザーのプロフィール画像">
                @else
                    <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                @endif
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('users.show', $post->user_id) }}">{{ $post->user->name }}</a></p>
            </div>
            <div class="text-left d-inline-block w-75">
                @if(isset($searchResults))  <!-- 検索結果表示 -->
                    <p class="mb-2 text-break">{!! preg_replace(
                        '/[' . preg_quote($searchQuery, '/') . ']/iu', 
                        '<span style="background-color: yellow;">$0</span>', 
                        $post->content
                    ) !!}</p>
                @else   <!-- 投稿一覧表示 -->
                    <p class="mb-2 text-break">{{ $post->content }}</p>
                @endif
                <!-- リプライが１つ以上の場合、リプライ一覧表示へのリンクを表示 -->
                @if ($post->replies->count() > 0)
                    <a href="{{ route('replies.index', $post->id) }}">リプライ{{ $post->replies->count() }}件をすべて見る</a>
                @endif
                <p class="text-muted">{{ $post->created_at }}</p>
            </div>
            <!-- 各アイコン -->
            <div class="d-flex justify-content-between w-50 pb-3 m-auto">
                <!-- 「イイね」 -->
                <a href="">
                    <i class="fa fa-thumbs-up fa-2x" style="color: black;"></i>
                </a>
                <!-- 「リプライ」 -->
                <a href="{{ route('replies.create', $post) }}">
                    <i class="fa fa-comment fa-2x" style="color: black;"></i>
                </a>
                @if(Auth::check() && Auth::id() == $post->user_id)
                    <!-- 投稿編集 -->
                    <a href="{{ route('post.edit', $post->id) }}">
                        <i class="fa fa-edit fa-2x" style="color: black;"></i>
                    </a>
                    <!-- 投稿削除 -->
                    <form method="POST" action="{{ route('post.delete', $post->id) }}" id="delete_{{ $post->id }}">                        
                        @csrf
                        @method('DELETE')
                        <i class="fa fa-trash fa-2x" style="color: red; cursor: pointer;" onclick="confirmDelete({{ $post->id }})"></i>                    
                    </form>
                @endif
            </div>
        </li>
    </ul>
@endforeach

@if(isset($searchResults))
    <div class="m-auto" style="width: fit-content;">
        {{ $searchResults->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
@else
    <div class="m-auto" style="width: fit-content;">
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
@endif

<script>
    function confirmDelete(postId) {
        if (confirm('本当に削除しますか？')) {
            document.getElementById('delete_' + postId).submit();
        }
    }
</script>