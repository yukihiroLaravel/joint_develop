@extends('layouts.app')
@section('content')
    <div class="row">
        @include('users.profile')
        <div class="col-sm-8">
            @include('users.tabs')
            @include('users.users_list')
        </div>
    </div>
@endsection