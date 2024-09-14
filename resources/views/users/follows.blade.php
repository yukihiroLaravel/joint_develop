@php
    require_once app_path('Helpers/ViewHelper.php');
    $viewHelper = \App\Helpers\ViewHelper::getInstance();

    $loginUserFollowingsContext = session('loginUserFollowingsContext');
@endphp

@if (!is_null($loginUserFollowingsContext))
    {{-- 「※特別対応分※」ログインユーザが、自分についてのユーザ詳細画面で「フォロー中」を表示してるケース --}}
    
    @foreach ($loginUserFollowingsContext->followingIds as $currentUserId)
        @php
            $user = App\User::find($currentUserId);
        @endphp

        {{-- 退会してる人はスキップ --}}
        @if (is_null($user))
            @continue
        @endif

        @php
            //「$followsParam」を作成する。
            $followsParam = $viewHelper->createFollowsParam($user);

            // 最新の投稿を1件取得 (投稿なしの場合はnull返却)
            $post = $user->latestPost();
        @endphp

        @include('posts.show', ['user' => $user, 'post' => $post, 'followsParam' => $followsParam])

        {{-- 退会済の人でスキップした分で、1ページの件数を満たさなかった不足分を --}}
        {{-- 「paginate」での取得分より補う実装を試みて、動作確認したところ、 --}}
        {{-- ページ内での居残りで、「フォロー」／「フォロー解除」を多数してる状況では、 --}}
        {{-- DB値を正直ベースで「paginate」で取得している分は、同じ内容のフォロー関係でもfollowsのidが都度、 --}}
        {{-- 最大値+1に変わるため、並び順が異なる。また、「フォロー解除」でなくなってる分、1ページ分の取得データの対象も、大きくズレる。 --}}
        {{-- 結果として、何がおきてるか把握できないような見た目になってしまった。 --}}
        {{-- そのため、この試みはあきらめた経緯があります。 --}}
        {{-- よって、この「※特別対応分※」の対象の処理中で、退会した人がいた場合のレアケースでは、 --}}
        {{-- 退会済の人がいた分、1ページに表示すべき件数より不足した件数での表示となります。 --}}
    @endforeach
@else
    {{-- 上記、以外の通常ケース --}}
    @foreach ($users as $user)
        @php
            //「$followsParam」を作成する。
            $followsParam = $viewHelper->createFollowsParam($user);

            $post = $user->latestPost();
        @endphp

        @include('posts.show', ['user' => $user, 'post' => $post, 'followsParam' => $followsParam])
    @endforeach
@endif
{{-- 上記が、いずれの分岐での処理をしてようが、「paginate」してるもので --}}
{{-- linksを実行しないとLaravelのページャー制御と整合しないだろう --}}
<div class="m-auto" style="width: fit-content">
    {{ $users->links('pagination::bootstrap-4') }}
</div>
