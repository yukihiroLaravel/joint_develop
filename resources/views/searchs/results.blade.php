@extends('layouts.app')
@section('content')
<div class="center jumbotron jumbotron-extend bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class=""></i><class="text-white">みんなの大喜利「GiriGiri」</h1>
    </div>  
</div>
@include('posts.posts', ['posts' => $posts])
@endsection
