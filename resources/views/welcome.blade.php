@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3"></i>Positive Oops</h1>
        </div>
    </div>

    <h5 class="text-center mb-3">"今日のやらかし"についてシェアしよう！</h5>

        @if (Auth::check())
            <div class="w-75 m-auto"></div>

            <div class="text-center mb-3">
                <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
                    @csrf

                    <div class="form-group">
                        <textarea class="form-control" name="content" rows="3"></textarea>

                    @error('content')
                        <div class='alert alert-danger mt-2'>
                            {{ $message}}
                        </div>
                    @enderror

                        <div class="text-left mt-3">
                            <button type="submit" class="btn btn-primary">やらかしをシェア</button>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        @include('posts.posts', ['posts' => $posts])

@endsection