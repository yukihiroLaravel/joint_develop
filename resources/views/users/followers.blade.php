@extends('layouts.app')
@section('content')
    @include('users.tabs',['user'=>$user])
    @include('users.show'['users'=>$users])
@endsection