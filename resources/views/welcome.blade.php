@extends('layouts.app')
@section('content') 
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3"></i>Topic Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
        <div class="w-75 m-auto">エラーメッセージが入る場所</div>
        <div class="text-center mb-3">
            <form method="" action="" class="d-inline-block w-75">
                <div class="form-group">
                    <textarea class="form-control" name="" rows=""></textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        </div>
@endsection



