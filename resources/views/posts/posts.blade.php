<ul class="list-unstyled">
    <li class="mb-3 text-center">
        @foreach ($posts as $post)
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('users.show', ['id' => $post->user_id]) }}">{{$post->user->name}}</a></p>
            </div>
            <div class="text-left d-inline-block w-75">
                <p class="mb-2">{{$post->content}}</p>
                <p class="text-muted">{{$post->updated_at}}</p>
                <div class="mb-3">
                    @if (Auth::check() && Auth::id() !== $post->user_id)
                        @php $isLiked = in_array($post->id, $likedPostIds); @endphp
                        <button type="button"
                                class="btn btn-sm border-0 p-0 like-button {{ $isLiked ? 'text-danger' : 'text-muted' }}"
                                data-post-id="{{ $post->id }}"
                                data-liked="{{ $isLiked ? '1' : '0' }}"
                                data-like-url="{{ route('post.like', $post->id) }}"
                                data-unlike-url="{{ route('post.unlike', $post->id) }}">
                            <span class="like-icon"><i class="{{ $isLiked ? 'fas' : 'far' }} fa-heart"></i></span>
                        </button>
                    @else
                        <i class="far fa-heart text-muted"></i>
                    @endif
                    <span class="like-count" data-post-id="{{ $post->id }}">{{ $post->likes_count }}</span>
                </div>
                @if (Auth::id() == $post->user_id)
                    <div class="text-right">
                        <form method="POST" action="{{ route('post.destroy', $post->id) }}" onsubmit="return confirm('本当に削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">削除</button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    </li>
</ul>
<div class="m-auto" style="width: fit-content">
    {{ $posts->links('pagination::bootstrap-4') }}
</div>
@push('scripts')
    <script src="{{ asset('js/like.js') }}"></script>
@endpush