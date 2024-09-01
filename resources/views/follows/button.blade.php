@php
    // $isFollowsBaseOk、がtrue時は、常に、$user->idは、
    // ログインユーザ以外なので、$otherUserIdの変数名としておく
    $otherUserId = $user->id;

    $isFollowsBaseOk = App\User::isFollowsBaseOk($followsParam, $otherUserId);
    if(!$isFollowsBaseOk) {
        // そもそも、フォロー関連のボタン表示すべきでない場合は何もしない
        return;
    }

    // ＜パターン1＞
    // 「フォロー中」である
    // 「フォロワー」である
    // 上記、AND条件が成立するケース
    $isControlPattern1 = ($followsParam->isFollowings && $followsParam->isFollowers);

    // ＜パターン2＞
    // 「フォロー中」である
    // 「フォロワー」でない
    // 上記、AND条件が成立するケース
    $isControlPattern2 = ($followsParam->isFollowings && !$followsParam->isFollowers);

    // ＜パターン3＞
    // 「フォロー中」でない
    // 「フォロワー」である
    // 上記、AND条件が成立するケース
    $isControlPattern3 = (!$followsParam->isFollowings && $followsParam->isFollowers);

    // ＜パターン4＞
    // 「フォロー中」でない
    // 「フォロワー」でない
    // 上記、AND条件が成立するケース
    $isControlPattern4 = (!$followsParam->isFollowings && !$followsParam->isFollowers);

    // 「form」タグは、デフォルトではブロック要素で、改行されて、下の段となってしまうため
    // それを防ぎたい。また、中身のフォロー系のボタンを強制的に右寄せしたい
    // これを実現するため試行錯誤した結果
    // 下記の値をstyleに指定すればよいと判明した
    // エスケープされないように、{!! $formTagStyle !!}  の形で指定する。
    // 当実装は仕様の変化に応じて、多目的な画面位置にインクルードされうるため
    // その場所に応じたレイアウト調整が行いやすいように、
    // 一旦、変数に値を詰め込み、当ロジックでの条件分岐で吸収可能な状況としたい
    $formTagStyle = 'style="overflow: hidden; float: right; display: inline;"';

    $actionValue = null;
    if ($isControlPattern1 || $isControlPattern2) {
        $actionValue = route('unfollow', $otherUserId);
    }
    if ($isControlPattern3 || $isControlPattern4) {
        $actionValue = route('follow', $otherUserId);
    }
    
@endphp

@if ($isControlPattern1 || $isControlPattern2 || $isControlPattern3 || $isControlPattern4)
    <form action="{{ $actionValue }}" method="POST" {!! $formTagStyle !!}>
        @csrf

        @if ($isControlPattern1 || $isControlPattern2)
            @method('DELETE')

            {{-- 「フォロー中」を表示し、マウスホバーで「フォロー解除」を表示のボタン--}}
            {{-- 押したら「unfollow」のサーバー処理を行う。--}}
            <button type="submit" class="btn btn-light rounded-pill" style="color: gray; border: 2px solid gray;"
                onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='red'; this.style.borderColor='red'; this.innerText='フォロー解除';" 
                onmouseout="this.style.backgroundColor='white'; this.style.color='gray'; this.style.borderColor='gray'; this.innerText='フォロー中';">フォロー中</button>
        @endif

        @if ($isControlPattern3)
            {{-- 「フォローバック」を表示し、--}}
            {{-- 押したら「follow」のサーバー処理を行う。--}}
            <button type="submit" class="btn btn-dark rounded-pill">フォローバック</button>
        @endif

        @if ($isControlPattern4)
            {{-- 「フォロー」を表示し、--}}
            {{-- 押したら「follow」のサーバー処理を行う。--}}
            <button type="submit" class="btn btn-dark rounded-pill">フォロー</button>
        @endif
    </form>
@endif
