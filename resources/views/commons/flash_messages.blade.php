{{--  仕組み上、複数件、可能な状況として柔軟性を高める --}}
@php
    if (!session('flashMessageInfos')) {
        return;
    }

    $flashMessageInfos = session('flashMessageInfos');
    if (count($flashMessageInfos) <= 0) {
        return;
    }
@endphp
@foreach ($flashMessageInfos as $info)

    @php
        $message = $info->message;
        $alertClass = $info->alertClass;
    @endphp

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

    <div class="alert alert-{{ $alertClass }} alert-dismissible fade show" role="alert" style="margin-bottom: 2px;">
        {{--  「Bootstrap 4」の右端の「×」ボタン --}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        {{ $message }}
    </div>
@endforeach
