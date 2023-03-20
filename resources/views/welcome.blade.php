@extends('layouts.app')
@section('content')
<div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3"></i>
            <svg class="svg-inline--fa fa-telegram fa-w-16 fa-lg pr-3" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="telegram" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" data-fa-i2svg=""><path fill="currentColor" d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm121.8 169.9l-40.7 191.8c-3 13.6-11.1 16.9-22.4 10.5l-62-45.7-29.9 28.8c-3.3 3.3-6.1 6.1-12.5 6.1l4.4-63.1 114.9-103.8c5-4.4-1.1-6.9-7.7-2.5l-142 89.4-61.2-19.1c-13.3-4.2-13.6-13.3 2.8-19.7l239.1-92.2c11.1-4 20.8 2.7 17.2 19.5z"></path></svg>Topic Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
        <div class="w-75 m-auto"></div>
        <div class="text-center mb-3">
            <form method="POST" action="https://laravel-fly.fly.dev/posts" class="d-inline-block w-75">
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="4"></textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        </div>
       
@endsection

