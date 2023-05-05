@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-danger ">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="fas fa-baseball-ball pr-3 d-inline"></i>大谷翔平選手応援掲示板</h1>
    </div>
</div>
@if (session('alertMessage'))
    <div class="alert alert-danger text-center w-75 mx-auto">
        {{ session('alertMessage') }}
    </div> 
@elseif (session('successMessage'))
    <div class="alert alert-success text-center w-75 mx-auto ">
        {{ session('successMessage') }}
    </div>
@elseif (session('createUserMessage'))
    <div class="alert alert-success text-center w-75 mx-auto ">
        {{ session('createUserMessage') }}
    </div>
@endif
<h5 class="description text-center">大谷選手について140字以内で投稿しましょう⚾️</h5>
@if (Auth::check())
    <div class="w-75 m-auto">@include('commons.error_messages')</div>
    <div class="text-center mb-3">
        <form method="post" action="{{ route('post.store') }}" class="d-inline-block w-75">
        @csrf
            <div class="form-group">
                <textarea class="form-control" name="contents" rows="4">{{ old('contents') }}</textarea>
                <div class="text-left mt-3">
                    <button type="submit" class="btn btn-success">投稿する</button>
                </div>
            </div>
        </form>
    </div>
@endif
@include('post.post',['posts' => $posts])
@endsection