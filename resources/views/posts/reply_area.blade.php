@php $depth = $depth ?? 0; @endphp

@if($post->replies->count() > 0)
    @if($depth < 3)
        <div class="replies-container mt-2 ml-4 border-left pl-3 text-left">
    @else
        <div class="replies-container mt-2 ml-0 border-top pt-2 text-left">
    @endif

        <details {{ !empty($keyword) || !empty($tag) ? 'open' : '' }}>
            <summary class="text-muted small" style="cursor: pointer;">
                <i class="fas fa-comments"></i> {{ $post->replies->count() }} 件の返信を表示
            </summary>
            
            <div class="mt-3">
                @foreach($post->replies as $reply)
                    <div class="reply-item mb-3">
                        <div class="d-flex align-items-center">
                            <img class="mr-2 rounded-circle" src="{{ Gravatar::src($reply->user->email, 30) }}" alt="アバター" style="width: 30px;">
                            <small><strong>{{ $reply->user->name }}</strong></small>
                        </div>

                        <div class="{{ $depth < 3 ? 'ml-5' : 'ml-4' }}">
                            <p class="mb-1">{{ $reply->content }}</p>

                            <div class="mb-2">
                                @include('favorites.favorite_button', ['post' => $reply])
                            </div>
                            
                            @auth
                                <details class="mb-2">
                                    <summary class="text-primary small" style="cursor: pointer;">返信する</summary>
                                    @include('posts.reply_form', ['parent_id' => $reply->id])
                                </details>
                            @endauth

                            @include('posts.reply_area', [
                                'post' => $reply, 
                                'depth' => $depth + 1,
                                'keyword' => $keyword ?? null,
                                'tag' => $tag ?? null
                            ])
                        </div>
                    </div>
                @endforeach
            </div>
        </details>
    </div>
@endif

<style>
    /* 3階層目以降のコンテナのマージンを強制的にゼロにする */
    .replies-container .replies-container .replies-container .replies-container {
        margin-left: 0 !important;
        padding-left: 0 !important;
        border-left: none !important;
    }
</style>
