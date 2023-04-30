@extends('layouts.app')
@section('content')  
 
<div class="row">
    <aside class="col-sm-4 mb-5">
        @include('commons.UserDetailsCard', ['followUser'=>$user])
        @include('users.follow_button', ['followUser'=>$user])
    </aside>
    <div class="col-sm-8">
        @include('commons.UserDetailsTab', ['followUser'=>$user])
        @include('post.post', ['posts' => $posts])
    </div>
 </div>
 @endsection