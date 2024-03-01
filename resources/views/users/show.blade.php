@extends('layouts.app')
@section('content')
<div class="row">
   <aside class="col-sm-4 mb-5">
      @include('partials.user_profile', ['user' => $user])
   </aside>
   @include('partials.user_tabs', ['user' => $user, 'posts' => $posts])
</div>
@endsection