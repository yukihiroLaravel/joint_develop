@php $depth = $depth ?? 0; @endphp

@if($post->replies->count() > 0)
    <div class="replies-container mt-2 {{ $depth < 2 ? 'ml-4 border-left pl-3' : 'ml-0 border-top pt-2' }} text-left">
        
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
                            <small class="text-muted ml-2">{{ $reply->created_at->diffForHumans() }}</small>
                        </div>

                        <div class="{{ $depth < 2 ? 'ml-5' : 'ml-4' }}">
                            <p class="mb-1">
                                @if(!empty($keyword))
                                    {!! str_replace($keyword, '<mark class="p-0">' . $keyword . '</mark>', e($reply->content)) !!}
                                @else
                                    {{ $reply->content }}
                                @endif
                            </p>

                            <div class="d-flex align-items-center mb-2">
                                @include('favorites.favorite_button', ['post' => $reply])
                                
                                @if(Auth::check() && Auth::id() == $reply->user_id)
                                    <div class="ml-3 d-flex align-items-center">
                                        <a href="{{ route('posts.edit', $reply->id) }}" class="btn btn-primary btn-sm mr-2">編集</a>
                                        <form method="POST" action="{{ route('posts.destroy', $reply->id) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('この返信を削除しますか？')">削除</button>
                                        </form>
                                    </div>
                                @endif
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
