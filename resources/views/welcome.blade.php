@extends('layouts.app')
<<<<<<< HEAD
 @section('content')
   <div class="center jumbotron bg-info">
       <div class="text-center text-white mt-2 pt-1">
           <h1><i class="pr-3"></i>Topic Posts</h1>
       </div>
   </div>
   <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
 @endsection
=======
@section('content')
<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="pr-3"></i>Topic Posts</h1>
    </div>
</div>
<h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
@include('posts.posts', ['posts' => $posts])
@endsection
>>>>>>> develop_b_nagatsuki_rab
