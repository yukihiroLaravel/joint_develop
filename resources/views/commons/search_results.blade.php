<div class="w-75 m-auto mb-4">
    <div class="d-flex justify-content-between align-items-center border-bottom mb-3 pb-2">
        <div>
            <p class="text-muted small mb-0">
                「{{ $search }}」の検索結果
            </p>
        </div>

        <a href="{{ route('posts.index') }}" class="btn btn-sm btn-link text-secondary p-0">
            検索をクリア
        </a>
    </div>

    @if (in_array($scope, ['posts', 'all'], true))
        <section class="mb-5">
            <h5 class="font-weight-bold">
                投稿（{{ $posts->total() }}件）
            </h5>

            @include('posts.posts', ['posts' => $posts])
        </section>
    @endif

    @if (in_array($scope, ['users', 'all'], true))
        <section class="mb-5">
            <h5 class="font-weight-bold">
                ユーザー名（{{ $users->total() }}件）
            </h5>

            @include('users.users', [
                'users' => $users,
                'emptyMessage' => '該当するユーザーはいません。'
            ])
        </section>
    @endif

    @if ($canSearchEncouragements && in_array($scope, ['encouragements', 'all'], true))
        <section class="mb-5">
            <h5 class="font-weight-bold">
                ひとことハゲマシ（{{ $encouragements->total() }}件）
            </h5>

            <ul class="list-unstyled">
                @forelse ($encouragements as $reaction)
                    <li class="mb-3">
                        <div class="border rounded p-3">
                            <div class="d-flex align-items-center mb-2">
                                <img
                                    src="{{ asset('images/reactions/' . $reaction->reaction_type . '.png') }}"
                                    alt="{{ $reactionTypes[$reaction->reaction_type] }}"
                                    class="mr-2"
                                    style="width: 36px; height: 36px; object-fit: contain;"
                                >

                                <span class="font-weight-bold">
                                    {{ $reactionTypes[$reaction->reaction_type] }}
                                </span>
                            </div>

                            <p class="mb-2">
                                {{ $reaction->encouragement }}
                            </p>

                            <p class="mb-0 small text-muted">
                                対象投稿：
                                <a href="{{ route('post.show', $reaction->post->id) }}">
                                    {{ $reaction->post->content }}
                                </a>
                            </p>
                        </div>
                    </li>
                @empty
                    <li class="text-center">
                        該当するひとことハゲマシはありません。
                    </li>
                @endforelse
            </ul>

            <div class="m-auto" style="width: fit-content">
                {{ $encouragements->links('pagination::bootstrap-4') }}
            </div>
        </section>
    @endif
</div>