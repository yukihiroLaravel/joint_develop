<ul class="list-unstyled">
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
             <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
             <p class="mt-3 mb-0 d-inline-block"><a  href="{{ route('users.show',$post->user_id) }}">{{ $post->user->name }}</a></p>
            </div>
            <div class=""> 
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
