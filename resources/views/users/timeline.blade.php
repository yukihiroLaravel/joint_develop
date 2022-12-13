@extends('users.show_common')
@section('data')
    @include('posts.posts', ['user' => $user, 'posts' => $posts])
@endsection