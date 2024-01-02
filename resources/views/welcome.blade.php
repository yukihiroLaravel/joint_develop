{{-- トップページ --}}
@extends('layouts.app')

{{-- 内容 --}}
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="pr-3"></i>Topic Posts</h1>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>

    @if(Auth::check())
    {{-- 投稿する --}}
        <div class="text-center mb-3">
            <form method="POST" action="{{ route('createPost') }}" class="d-inline-block w-75">
                @csrf {{-- CSRFトークンを追加 --}}
                {{-- フラッシュメッセージ表示 --}}
                @include('commons.flash_message')
                <div class="form-group">
                    @include('commons.error_messages')
                    <textarea class="form-control" name="content" rows="2">{{ old('content') }}</textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
            <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="img_path">
                <input type="submit" value="アップロード">
            </form>
            <h1>一覧画面</h1>
                @foreach ($items as $item)
                    <img src="{{ Storage::url($item->img_path) }}" width="25%">
                @endforeach
        </div>
    @endif
    {{-- 投稿一覧 --}}
    @if($posts->isEmpty())
        <p class="text-danger">検索結果：0件</p>
    @else
        @include('posts.index', ['posts' => $posts])
    @endif
@endsection


