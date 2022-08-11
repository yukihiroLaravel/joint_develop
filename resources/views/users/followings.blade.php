@extends('layouts.app')
@section('content')
    @include('users.tabs',['user'=>$user])
@endsection
