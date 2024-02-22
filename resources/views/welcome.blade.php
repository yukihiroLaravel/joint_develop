@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white">
            <h1><i class="fa-brands fa-telegram mr-2"></i>Topic Posts</h1>
            <form method="GET" action="{{ route('search') }}" class="col-lg-6 col-md-8 col mr-auto ml-auto search_form">
                @csrf
                <input type="text" name="searchWords" value="{{ isset($searchWords) ? $searchWords : '' }}"
                    class="form-control input-group-prepend" placeholder="検索する">
                <button type="submit" class="input-group-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
    <h5 class="text-center mb-3">"○○"について140字以内で会話しよう！</h5>
    <div class="w-75 m-auto">@include('commons.error_messages')</div>
    @if (Auth::check())
        <div class="text-center mb-3 pt-3">
            <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="4">{{ old('content') }}</textarea>
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
    @if (isset($arraySearchWords))
        @php
            $searchedWords = implode('",' . "\n" . '"', $arraySearchWords);
        @endphp
        @if ($posts->count() == 0)
            <h5 class="text-center mt-5 mb-5"><span class="searched_words">"{{ $searchedWords }}"</span>が含まれる投稿はありませんでした。
            </h5>
        @else
            <h5 class="text-center mb-3"><span class="searched_words">"{{ $searchedWords }}"</span>の検索結果</h5>
        @endif
    @endif
    @include('posts.posts', ['posts' => $posts])
    <div class="d-flex justify-content-center">
        @if (isset($searchWords))
            {{ $posts->appends(['searchWords' => $searchWords])->links('pagination::bootstrap-4') }}
        @else
            {{ $posts->links('pagination::bootstrap-4') }}
        @endif
    </div>
@endsection
