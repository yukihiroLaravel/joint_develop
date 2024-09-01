@php
    $loginUserFollowingsContext = session('loginUserFollowingsContext');
@endphp

@if (!is_null($loginUserFollowingsContext))
    {{-- ※特別対応分※ --}}
    {{-- ログインユーザが、自分についてのユーザ詳細画面で --}}
    {{--「フォロー中」を表示してるケースでの「フォロー／アンフォロー」操作での表示更新のケース --}}

    @foreach ($loginUserFollowingsContext->followingIds as $currentUserId)
        @php
            $user = App\User::find($currentUserId);
        @endphp

        {{-- 退会してる人はスキップ --}}
        @if (is_null($user))
            @continue
        @endif

        @php
            $followsParam = App\User::createDefaultFollowsParam();
            $otherUserId = $user->id;
            App\User::updateFollowsParam($followsParam, $otherUserId);

            $post = $user->latestPost();
        @endphp

        @include('posts.show', ['user' => $user, 'post' => $post, 'followsParam' => $followsParam])

        {{-- 特記事項 --}}
        {{-- ここで、処理済みのuserIdをリスト上に記憶し --}}
        {{-- 退会済の人でスキップした分で、1ページの件数を満たさなかった不足分を --}}
        {{-- 「paginate」での取得分より、処理済みのuserIdになければ、処理する --}}
        {{-- 実装を試みて、動作確認したところ、ページ内での居残りで、「フォロー」／「フォロー解除」を多数してる状況では、 --}}
        {{-- DB値を正直ベースで「paginate」で取得している分は、followsのidが同じ内容のフォロー関係でも変わって並び順が異なる --}}
        {{-- また、「フォロー解除」でなくなってる分、1ページ分の取得データの対象も、大きくズレる。 --}}
        {{-- 結果として、何がおきてるか把握できないような見た目になってしまった。 --}}
        {{-- そのため、この試みはあきらめた経緯があります。 --}}
        {{-- よって、この「※特別対応分※」の対象の処理中で、退会した人がいた場合は、最終ページ以外などで、本来は1ページ分の --}}
        {{-- 件数が表示されるべきケースにおいても、退会済の人がいた分、不足した件数での表示更新となります。 --}}
        {{-- 以上、「※特別対応分※」の対象の処理中で、退会済の人がいた場合のレアケースに限定の説明でした。 --}}
    @endforeach
@else
    {{-- 上記、以外の通常ケース --}}
    @foreach ($users as $user)
        @php
            $followsParam = App\User::createDefaultFollowsParam();
            $otherUserId = $user->id;
            App\User::updateFollowsParam($followsParam, $otherUserId);

            $post = $user->latestPost();
        @endphp

        @include('posts.show', ['user' => $user, 'post' => $post, 'followsParam' => $followsParam])
    @endforeach
@endif
{{-- 上記が、いずれの分岐での処理をしてようが、「paginate」してるもので --}}
{{-- linksを実行しないとLaravelのページャー制御と整合しないだろう --}}
{{ $users->links('pagination::bootstrap-4') }}
