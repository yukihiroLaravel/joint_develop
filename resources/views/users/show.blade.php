@extends('layouts.app')
@section('content')
<div class="row">
      @include('partials.user_profile', ['user' => $user])
   <div class="col-sm-8">
      @include('partials.user_tabs', ['user' => $user])
      @include('posts.posts', ['user' => $user, 'posts' => $posts])
   </div>
</div>
@endsection