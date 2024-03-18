@extends('layouts.app') 
@section('content')
    @include('comments.post', ['post' => $post])
    <div style="margin-top: 20px;"></div>
    @include('comments.index', ['comments' => $comments])
    <div style="margin-top: 40px;"></div>
    @include('comments.form')
@endsection