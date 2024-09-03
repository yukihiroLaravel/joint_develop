@php
    require_once app_path('Helpers/ViewHelper.php');
    $viewHelper = \App\Helpers\ViewHelper::getInstance();

    // フォローボタンに関する設定情報を取得する。
    $config = $viewHelper->getFollowButtonConfig($followsParam);

    if(!$config->isFollowButtonVisible) {
        return;
    }
@endphp

<form action="{{ $config->actionValue }}" method="POST" {!! $config->formTagStyle !!}>
    @csrf

    @if ($config->isControlPattern1 || $config->isControlPattern2)
        @method('DELETE')

        {{-- 「フォロー中」を表示し、マウスホバーで「フォロー解除」を表示のボタン--}}
        {{-- 押したら「unfollow」のサーバー処理を行う。--}}
        <button type="submit" class="btn btn-light rounded-pill" style="color: gray; border: 2px solid gray;"
            onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='red'; this.style.borderColor='red'; this.innerText='フォロー解除';" 
            onmouseout="this.style.backgroundColor='white'; this.style.color='gray'; this.style.borderColor='gray'; this.innerText='フォロー中';">フォロー中</button>
    @endif

    @if ($config->isControlPattern3)
        {{-- 「フォローバック」を表示し、--}}
        {{-- 押したら「follow」のサーバー処理を行う。--}}
        <button type="submit" class="btn btn-dark rounded-pill">フォローバック</button>
    @endif

    @if ($config->isControlPattern4)
        {{-- 「フォロー」を表示し、--}}
        {{-- 押したら「follow」のサーバー処理を行う。--}}
        <button type="submit" class="btn btn-dark rounded-pill">フォロー</button>
    @endif
</form>
