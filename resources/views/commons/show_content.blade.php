{{-- 
    nl2br(e($currentContent))
    で改行コードをbrタグに変更するなどして
    それでも残った文字列について、「$viewHelper->toLink()」を行うことで
    改行はweb画面上見えつつも、http://や、https://などについては、_blankする
    *.blade.phpの実装を、当コンポーネントで部品化する。
--}}
@php
    require_once app_path('Helpers/ViewHelper.php');
    $viewHelper = \App\Helpers\ViewHelper::getInstance();
@endphp
{!! $viewHelper->toLink( nl2br(e($currentContent)) ) !!}
