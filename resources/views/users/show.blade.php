@extends('layouts.app')
@section('content')
@include('commons.flash_message')
<div class="row">
    @include('users.users')
    <div class="col-sm-8">
        @include('users.tabs')
        <ul class="list-unstyled">
            @include('posts.post')
        </ul>
    </div>
</div>
@endsection