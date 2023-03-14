@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-info">
     <div class="text-center text-white mt-2 pt-1">
        <h1><i class="fas fa-weight" aria-hidden="true"></i>ダイエットーーク！</h1>
     </div>
</div>
     <div class="text-center mb-3">
        <form method="post" action="{{ route('posts.store') }}" class="d-inline-block w-75" > 
<h5 class="text-center mb-3">ダイエットのかたり場（140字以内）</h5>
    @include('commons.error_messages')            
            @csrf
            @if (session('successMessage'))
                <div class="alert alert-success text-center">
                    {{ session('successMessage') }}
                </div>
            @endif
            @if (session('withdrawal_flash_message'))
                <div class='alert alert-danger'>
                    {{ session('withdrawal_flash_message') }}
                </div>
            @endif
            <div class="form-group">
                @if(Auth::check())
                    <textarea class="form-control" name="content" rows="5"></textarea>
                    <div class="text-left mt-3">
                    <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                @endif
            </div>
        </form>
    </div>
    @include( 'posts.posts',['posts' => $posts])
@endsection
