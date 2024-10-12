@php
    require_once app_path('Helpers/ViewHelper.php');
    $viewHelper = \App\Helpers\ViewHelper::getInstance();

    if (!isset($followsParam)) {
        // 「$followsParam」が未定義の場合(呼び元で指定がない場合)は、デフォルト値を指定
        $followsParam = \App\User::createDefaultFollowsParam();
    }
@endphp
<ul class="list-unstyled">

    <li class="mb-3 text-center">

        @if ($followsParam->isFollowerIndicatorVisible)
            <div class="text-left d-inline-block w-75 mb-2">
                <i class="fas fa-user"></i>&nbsp;<span>フォローされています</span>
            </div>
        @endif

        <div class="text-left d-inline-block w-75 mb-2">
            @include('commons.avatar', [
                'editFlg' => 'OFF',
                'imageSize' => '55',
                'user' => $user,
                'class' => 'mr-2 rounded-circle',
            ])
            <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $user->id) }}" title="{{ $user->name }}">{{ $user->truncateName() }}</a></p>

            @if ($followsParam->isFollowsBaseOk)
                @include('follows.button', ['followsParam' => $followsParam])
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
                    @include('commons.carousel', ['post' => $post])
                    @include('commons.categories_links', ['post' => $post])
                    <p class="text-muted">{{ $post->created_at }}</p>
                </div>
                @if (Auth::id() === $post->user_id)
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form onsubmit="return confirm('本当に削除しますか？')" method="POST" action="{{ route('post.delete', $post->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        @php
                            $previousUrlParameter = $viewHelper->getPreviousUrlParameter();
                        @endphp
                        <a href="{{ route('post.edit', ['id' => $post->id] + $previousUrlParameter) }}" class="btn btn-primary">編集する</a>
                    </div>
                @endif
                <div class="card bg-light d-inline-block w-75 px-5 pt-0 pb-3">
                    <div class="row">
                        <div class="col-6 px-4 pt-3">
                            @if ($post->replies->count())
                            <a href="{{ route('reply.show', $post->id) }}">
                                返信 {{$post->replies->count()}}件
                            </a>
                            @else
                            <a>返信はまだありません。</a>
                            @endif
                        </div>
                        @auth
                            <div class="col-6 px-4 pt-3"> 
                            <button type="button" class="btn btn-primary">
                                <a class="text-decoration-none" href="{{ route('reply.show', $post->id) }}" style="color:white;">返信する</a>
                            </button>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        @endif
    </li>
</ul>
