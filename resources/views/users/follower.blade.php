@extends('layouts.app')
@section('content')
	<div class="row">
    	@include('users.aside', ['user' => $user])
        <div class="col-sm-8">
            @include('users.nav_tabs', ['user' => $user])
        	@include('follow.follower_list', ['follower' => $followers])
        </div>
     </div>
@endsection