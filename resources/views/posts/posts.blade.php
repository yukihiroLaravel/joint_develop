<ul class="list-unstyled">
    @forelse ($posts as $post)
        <li class="mb-3 text-center border-bottom">
            <div class="text-left d-inline-block w-75 mb-2">

                @if($post->user->avatar)
                    <img
                        class="mr-2 rounded-circle"
                        src="{{ asset('storage/' . $post->user->avatar) }}"
                        alt="{{ $post->user->name }}のアバター画像"
                        width="55"
                        height="55"
                    >
                @else
                    <img
                        class="mr-2 rounded-circle"
                        src="{{ Gravatar::src($post->user->email, 55) }}"
                        alt="{{ $post->user->name }}のアバター画像"
                    >
                @endif

                <p class="mt-3 mb-0 d-inline-block">
                    <a href="{{ route('user.show', $post->user->id) }}">
                        {{ $post->user->name }}
                    </a>
                </p>
            </div>

            <div>
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">
                        <a href="{{ route('post.show', $post->id) }}">
                            {{ $post->content }}
                        </a>
                    </p>

                    @if ($post->tags->isNotEmpty())
                        <div class="mb-2">
                            @foreach ($post->tags as $tag)
                                <a
                                    href="{{ route('tag.show', $tag->id) }}"
                                    class="badge mr-1"
                                    style="background-color: #97b7a4; color: #ffffff;"
                                >
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    @if ($post->image_path)
                        <div class="mt-2 mb-3 text-left">
                            <a href="{{ route('post.show', $post->id) }}">
                                <img 
                                    src="{{ asset('storage/' . $post->image_path) }}" 
                                    alt="添付画像" 
                                    class="img-fluid rounded border" 
                                    style="max-height: 280px; width: auto; object-fit: contain;"
                                >
                            </a>
                        </div>
                    @endif

                    <div class="d-flex align-items-center mt-2 mb-2">
                        @foreach ($reactionTypes as $type => $label)
                            <div class="mr-3 text-center">
                                <img
                                    src="{{ asset('images/reactions/' .$type . '.png') }}"
                                    alt="{{ $label }}"
                                    style="width: 32px; height: 32px;"
                                >
                                @php
                                    $count = $post->reactions->where('reaction_type', $type)->count();
                                @endphp

                                <div>
                                    @if ($count > 0)
                                        {{ $count }}
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <p class="text-muted">
                        {{ $post->created_at }}
                    </p>
                </div>
                @if (Auth::check() && Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="POST" action="{{ route('post.destroy', $post->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="{{ route('post.edit', $post->id) }}"
                            class="btn btn-primary">編集する</a>
                        </div>
                @endif
            </div>
        </li>
    @empty
        <li class="text-center">
            投稿はありません。
        </li>
    @endforelse
</ul>

<div class="m-auto" style="width: fit-content">
    {{ $posts->links('pagination::bootstrap-4') }}
</div>