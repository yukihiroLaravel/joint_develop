@php
    $isFollowsBaseOk = App\User::isFollowsBaseOk($followsParam, $user->id);
@endphp
<ul class="list-unstyled">

        <li class="mb-3 text-center">

            @if ($isFollowsBaseOk && $followsParam->isFollowers)
                <div class="text-left d-inline-block w-75 mb-2">
                    <i class="fas fa-user"></i>&nbsp;<span>フォローされています</span>
                </div>
            @endif

            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $user->id) }}" title="{{ $user->name }}">{{ $user->truncateName() }}</a></p>

                @if ($isFollowsBaseOk)
                    @include('follows.button', ['user' => $user, 'followsParam' => $followsParam])
                @endif
            </div>

            {{-- ************************************************************ --}}
            {{-- 「フォロー中」、「フォロワー」のリスト表示のコンテクストから --}}
            {{-- インクルードされているケースは、$userに紐づく最新の投稿1件での処理だが、 --}}
            {{-- 1件も投稿していない$userのケースは、$postがnullとなってる --}}
            {{-- そのケースは投稿内容を表示したくないため($postがnullだとエラーになる) --}}
            {{-- 「!is_null($post)」の判定をしている --}}
            {{-- ************************************************************ --}}
            @if (!is_null($post))
                <div class="">
                    <div class="text-left d-inline-block w-75">
                        <p class="mb-2"></p>
                        <p class="text-muted">{!! nl2br(e($post->content)) !!}</p>
                        <p class="text-muted">{{ $post->created_at }}</p>
                    </div>
                    @if (Auth::id() === $post->user_id)
                        <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                            <form method="" action="">
                                <button type="submit" class="btn btn-danger">削除</button>
                            </form>
                            <a href="" class="btn btn-primary">編集する</a>
                        </div>
                    @endif
                </div>
            @endif
        </li>
</ul>
<div class="m-auto" style="width: fit-content"></div>
