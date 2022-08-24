@extends('layouts.app')
@section('content')
    @include('users.tabs',['user'=>$user])
    @include('users.users',['users'=>$users])
@endsection