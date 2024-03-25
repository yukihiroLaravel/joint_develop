@extends('layouts.app') 
@section('content')
    @include('comments.post', ['post' => $post])
    @include('comments.index', ['comments' => $comments])
    @include('comments.form')
@endsection