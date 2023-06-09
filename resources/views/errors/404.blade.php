@extends('errors.layouts.base')

@section('title', '404 Not Found')

@section('message', 'The page of the corresponding address could not be found.')
{{-- 該当アドレスのページを見つける事ができませんでした。 --}}

@section('detail', 'The server indicates that it could not find the requested resource. A typo in the URL, or the page may have been moved or deleted. Please go back to the top page or search again.')
{{-- サーバーは要求されたリソースを見つけることができなかったことを示します。 URL のタイプミス、もしくはページが移動または削除された可能性があります。 トップページに戻るか、もう一度検索してください。 --}}

@section('link')
  <p><a href="{{env('APP_URL')}}">to TOP&gt;&gt;</a></p>
@endsection