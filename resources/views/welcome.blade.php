@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-success">
        <div class="text-center text-white mt-2 pt-1">
        <h1><i class="fab fa-telegram fa-lg pr-3"></i>お役立ち情報 for エンジニア</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">これは役に立ったと思ったものを140字以内でシェアしよう！</h5>
        <div class="w-75 m-auto">
            @include('commons.error_messages')
        </div>
        <div class="text-center mb-3">
            <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
                @csrf
                @if (Auth::check())
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="4"></textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
                @endif
                        {{-- 投稿のフラッシュメッセージ --}}
                        @if (session('createMessage'))
                            <div class="alert alert-success text-center">
                        {{ session('createMessage') }}
                            </div>
                        @endif
                        {{-- フラッシュメッセージ終わり --}}
                        {{-- 更新のフラッシュメッセージ --}}
                        @if (session('updateMessage'))
                            <div class="alert alert-primary text-center">
                        {{ session('updateMessage') }}
                            </div>
                        @endif
                        {{-- フラッシュメッセージ終わり --}}

                        {{-- 削除のフラッシュメッセージ --}}
                        @if (session('deleteMessage'))
                            <div class="alert alert-danger text-center">
                        {{ session('deleteMessage') }}
                            </div>
                        @endif
                        {{-- フラッシュメッセージ終わり --}}

                        {{-- フォローのフラッシュメッセージ --}}
                        @if (session('followMessage'))
                            <div class="alert alert-primary text-center">
                        {{ session('followMessage') }}
                            </div>
                        @endif
                        {{-- フラッシュメッセージ終わり --}}

                        {{-- アンフォローのフラッシュメッセージ --}}
                        @if (session('UnfollowMessage'))
                            <div class="alert alert-danger text-center">
                        {{ session('UnfollowMessage') }}
                            </div>
                        @endif
                        {{-- フラッシュメッセージ終わり --}}

            </form>
        </div>
    @include('posts.posts', ['posts' => $posts])
@endsection