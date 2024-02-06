<!-- resources/views/home.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3 fas fa-paper-plane"></i>Topic Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"趣味や仕事"について140字以内で会話しよう！</h5>
    {{-- エラーメッセージが入る場所 --}}
    <div class="w-75 m-auto">
        {{-- エラーメッセージのコードが入ります --}}
    </div>
    {{-- テキストボックスと投稿ボタン --}}
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