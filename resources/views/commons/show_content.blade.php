{{-- 
    nl2br(e($currentContent))
    で改行コードをbrタグに変更するなどして
    それでも残った文字列について、「$viewHelper->convShowContent()」を行うことで
    改行はweb画面上見えつつも、http://や、https://などについては、_blank指定のaタグに変換する。
    さらに、半角スペースもweb上、textareで入力した時の値と同様に見えるように対処する。
    それを「  デフォルトのfont-sizeや、継承元のfont-sizeが変わってしまう  」preタグを使わずに実現する。
    上記の実装を、当コンポーネントで部品化する。
    他の様々な問題点が将来あったとしても、ViewHelper.phpなどを総動員して利用コードの修正なしで
    吸収して解決可能な布石を作るため部品化する。
--}}
@php
    require_once app_path('Helpers/ViewHelper.php');
    $viewHelper = \App\Helpers\ViewHelper::getInstance();
@endphp
{!! $viewHelper->convShowContent( nl2br(e($currentContent)) ) !!}
