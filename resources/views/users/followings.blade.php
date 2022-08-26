@extends('layouts.app')
@section('content')
    <div class="row">
        @include('users.users')
        <div class="col-sm-8">
            @include('users.tabs')
            @include('users.follow_common')
        </div>
    </div>
@endsection