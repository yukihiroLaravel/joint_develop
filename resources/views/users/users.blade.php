@if (isset($arraySearchWords))
    @php
        $searchedWords = implode('",' . "\n" . '"', $arraySearchWords);
    @endphp
    <h5 class="text-center mt-4 mb-4"><span class="searched_words">
            @if ($users->count() == 0)
                "{{ $searchedWords }}"
        </span>が含まれるユーザーはいませんでいた。
    @else
        "{{ $searchedWords }}"</span>を名前に含むユーザーが{{ $users->count() }}人見つかりました</h5>
@endif
</h5>
@endif
<ul class="list-unstyled">
    @foreach ($users as $user)
        @php
            $lastPost = $user->posts()->orderBy('id', 'desc')->first();
        @endphp
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="">{{ $user->name }}</a></p>
            </div>
            <div>
                <div class="text-left d-inline-block w-75">
                    @if (isset($lastPost->content))
                        <p class="mb-1">最新の投稿</p>
                        <p class="mb-2">{!! nl2br(e($lastPost->content)) !!}</p>
                        <p class="text-muted">{{ $lastPost->created_at }}</p>
                    @else
                        <p>まだ投稿はありません。</p>
                    @endif
                    {{-- @include('follow.follow_button', ['user' => $user]) --}}
                </div>
                @if ($user->id == Auth::id())
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="" action="">
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="" class="btn btn-primary">編集する</a>
                    </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>
<div class="d-flex justify-content-center">
    @php
        $activeList = 'users';
    @endphp
    @if (isset($searchWords))
        {{ $users->appends(['activeList' => $activeList, 'searchWords' => $searchWords])->links('pagination::bootstrap-4') }}
    @else
        {{ $users->appends(['activeList' => $activeList])->links('pagination::bootstrap-4') }}
    @endif
</div>
