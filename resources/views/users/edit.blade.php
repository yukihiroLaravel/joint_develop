@extends('layouts.app')
@section('content')
                    <form action="{{ route('users.delete', $user->id) }}" method="POST"><!-- 削除ルーティング名　-->
                        @csrf<!-- ハッキングの手口から守る（POST実行時は必ず記載） -->
                        @method('DELETE')<!-- HTTPメソッドをDELETEに指定 -->
@endsection