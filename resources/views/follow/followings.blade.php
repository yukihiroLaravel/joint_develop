@extends('layouts.app')
@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        @include('users.user_card', ['followUser'=>$user])
    </aside>
    <div class="col-sm-8">
        @include('users.user_tab')
        @include('users.followings_followers')
    </div>
</div>
@endsection