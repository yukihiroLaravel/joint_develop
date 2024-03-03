@extends('layouts.app')
@section('content')
<div class="row">
   <aside class="col-sm-4 mb-5">
      @include('partials.user_profile', ['user' => $user])
   </aside>
   <div class="col-sm-8">
      @include('partials.user_tabs', ['user' => $user])
      @include('posts.posts', ['user' => $user, 'posts' => $posts])
   </div>
</div>
@endsection