{{-- 仕組み上、複数件、可能な状況として柔軟性を高める --}}
@php
    /*
        前処理にて「'flashMessageInfos'でsessionにない、または、あるが0件」
        の場合は、なにもしないでreturnしている
    */
    if (!session('flashMessageInfos')) {
        return;
    }

    $flashMessageInfos = session('flashMessageInfos');
    if (count($flashMessageInfos) <= 0) {
        return;
    }
@endphp
@foreach ($flashMessageInfos as $info)

    {{-- ********************************************** --}}
    {{-- Laravelフラッシュメッセージの表示領域 --}}
    {{-- ********************************************** --}}
    {{-- alert-success: 成功（緑）・・・showFlashSuccess($message) --}}
    {{-- alert-danger: エラー（赤）・・・showFlashDanger($message) --}}
    {{-- alert-warning: 警告（黄）・・・showFlashWarning($message) --}}
    {{-- alert-info: 情報（青）・・・showFlashInfo($message) --}}
    {{-- app/Http/Controllers/Controller.php --}}
    {{-- にて定義した表示メソッドで指定した内容を表示する領域 --}}
    {{-- ********************************************** --}}

    <div class="alert alert-{{ $info->alertClass }} alert-dismissible fade show myserver-flash-marking" role="alert" style="margin-bottom: 2px;">
        {{--  「Bootstrap 4」の右端の「×」ボタン --}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        {!! nl2br(e($info->message)) !!}
    </div>
@endforeach
@php
    /*
        javascript関数として定義したhideFlashMessages()のテストを実施時に、
        テストのためトップ画面の初期表示時、いくつかメッセージ出力させて、動作確認中のことだが、

        トップ画面表示中に、ヘッダー部のユーザ名をクリックし、ユーザ詳細画面へ遷移したところ
        ユーザ詳細画面の初期表示時に、同じメッセージが出力される不具合を発見した。
        ( 他の操作では、そんなことはなく、なぜ、それだけ、そうなるのかまでは不明 )

        調べていくと
        withと異なり、session()->flash(キー、バリュー)で作った値は、次リクエストに残ることがあるとのこと

        そこで、表示が終わったこのタイミングで明示的な削除処理を実行することにした。

        上記、不具合はなくなった。

        ほとんどのケースはwithを用いるが、session()->flash(キー、バリュー)を使う必要がある場合は
        今回のケースのように消す処理も視野に入れたほうがよいだろう
    */
    session()->forget('flashMessageInfos');
@endphp
