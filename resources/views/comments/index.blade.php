@extends('layouts.app')
@section('content')
    <h2 class="mt-5">コメント一覧</h2>
    <ul>
        @foreach ($comments as $comment)
        <li>{{ $comment->content }}</li> 
        @endforeach
    </ul>
@endsection