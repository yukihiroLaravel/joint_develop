@extends('layouts.app')
@section('content')
<div class="row">
   @include('commons.common_users_show',['user' => $user])
   <div class="col-sm-8">
      @include('commons.common_tab',['user' => $user])
      @include('posts.post',['user' => $user,'posts' => $posts])
   </div>
</div>
@endsection