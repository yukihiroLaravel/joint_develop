@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
            <div class="text-center text-white mt-2 pt-1">
                <h1><i class="pr-3"></i>Topic Posts</h1>
            </div>
        </div>
        
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
    @foreach ($posts as $post)
        <ul class="list-unstyled">
            <li class="mb-3 text-center">
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="" alt="ユーザのアバター画像">
                    <p class="mt-3 mb-0 d-inline-block"><a href=""></a></p>
                </div>
                <div class="">
                    <div class="text-left d-inline-block w-75">
                        <p class="mb-2"></p>
                        <p class="text-muted"></p>
                    </div>
                        
                </div>
            </li>
        </ul>
    @endforeach



    
@endsection
