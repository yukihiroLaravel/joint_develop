<ul class="list-unstyled">
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
            @if (isset($post->user->profile_image) && $post->user->profile_image)
                <img class="rounded-circle img-fluid" src="{{ asset('storage/profile_images/' . $post->user->profile_image) }}" alt="ユーザーのプロフィール画像" style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover;">
            @else
                <img class="rounded-circle img-fluid" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
            @endif  
            <p class="mt-3 mb-0 d-inline-block">
                <a  href="{{ route('users.show',$post->user_id) }}">{{ $post->user->name }}</a>
             </p>
            </div>
            <div>
                @if ($post->youtube_id)
                    <iframe width="290" height="163.125" src="{{ 'https://www.youtube.com/embed/'.$post->youtube_id }}?controls=1&loop=1&playlist={{ $post->youtube_id }}" frameborder="0"></iframe>
                @else
                    <iframe width="290" height="163.125" src="https://www.youtube.com/embed/" frameborder="0"></iframe>
                @endif
            </div>
            <div class="text-left d-inline-block w-75">
                <p class="mb-2 text-break">{{ $post->content }}</p>
                @if ($post->replies->count() > 0)   <!-- リプライが１つ以上の場合、リプライ一覧表示へのリンクを表示 -->
                    <a href="{{ route('replies.index', $post->id) }}">リプライ{{ $post->replies->count() }}件をすべて見る</a>
                @endif
                <p class="text-muted">{{ $post->created_at }}</p>
            </div>
        </li>
</ul>
