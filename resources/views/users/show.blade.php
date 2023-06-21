@extends('layouts.app')
@section('content')
@include('commons.success')
<div class="row">
    <aside class="col-sm-4 mb-5">
        @include('users.user_card')
    </aside>
    <div class="col-sm-8">
        @include('users.user_tab')
        @include('posts.posts', ['posts' => $posts])
    </div>
</div>
@endsection