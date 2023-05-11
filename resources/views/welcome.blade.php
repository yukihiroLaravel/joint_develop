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
    @endif
    <h5 class="description text-center">大谷選手について140字以内で投稿しましょう⚾️</h5>
    <div class="w-75 m-auto">@include('commons.error_messages')</div>
    <div class="text-center mb-3">
        <form method="get" action="{{ route('post.index') }}" class="d-inline-block w-75">
            <div class="form-group ">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="検索"  value="{{ request()->input('keyword') }}"autocomplete="on">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-success">検索</button>
                    </div>
                </div>
            </div>
        </form>
        @if (Auth::check())
            <form method="post" action="{{ route('post.store') }}" class="d-inline-block w-75">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="contents" rows="4">{{ old('contents') }}</textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-success">投稿する</button>
                    </div>
                </div>
            </form>
        @endif 
    </div>
@include('post.post',['posts' => $posts])
@endsection