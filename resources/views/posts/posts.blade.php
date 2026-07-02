<ul class="list-unstyled">
    @forelse ($posts as $post)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img
                    class="mr-2 rounded-circle"
                    src="{{ Gravatar::src($post->user->email, 55) }}"
                    alt="{{ $post->user->name }}のアバター画像"
                >

                <p class="mt-3 mb-0 d-inline-block">
                    <a href="{{ route('user.show', $post->user->id) }}">
                        {{ $post->user->name }}
                    </a>
                </p>
            </div>

            <div>
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">
                        {{ $post->content }}
                    </p>

                    <p class="text-muted">
                        {{ $post->created_at }}
                    </p>
                </div>
                @if (Auth::check() && Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-end w-75 pb-3 m-auto">
                        <a
                            href="{{ route('post.edit', $post->id) }}"
                            class="btn btn-primary"
                        >
                            編集する
                        </a>
                        <form
                            method="POST"
                            action="{{ route('post.destroy', $post->id) }}"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">
                            この投稿を削除する
                            </button>
                        </form>
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