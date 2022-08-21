@extends('layouts.app')
@section('content')
            @include('users.show',['users'=>$users])
@endsection