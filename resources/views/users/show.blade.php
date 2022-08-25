@extends('layouts.app')
@section('content')
<div class="row">
    @include('users.users')
    <div class="col-sm-8">
        @include('users.tabs',['user'=>$user])
        <ul class="list-unstyled">
            @include('posts.post')
        </ul>
    </div>
</div>
@endsection