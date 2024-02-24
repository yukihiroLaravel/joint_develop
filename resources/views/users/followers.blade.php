@if ($countFollowerUsers == 0)
    <li>
        <p>フォロワーがいません。</p>
    </li>
@else
    @foreach ($followerUsers as $followerUser)
        @php
            $lastPost = $followerUser->posts()->orderBy('id', 'desc')->first();
            $user = $followerUser;
        @endphp

        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($followerUser->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="">{{ $followerUser->name }}</a>
                    @include('follow.follow_button', ['user' => $user])</p>
            </div>
            <div class="">
                <div class="text-left d-inline-block w-75">
                    @if (isset($lastPost->content))
                        <p class="mb-2">{{ $lastPost->content }}</p>
                        <p class="text-muted">{{ $lastPost->created_at }}</p>
                    @else
                        <p>まだ投稿はありません。</p>
                    @endif
                </div>
                @if ($followerUser->id == Auth::id())
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
@endif
