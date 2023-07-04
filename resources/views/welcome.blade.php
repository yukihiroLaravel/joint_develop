@extends('layouts.app')
@section('content')
@include('commons.success')
    <div class="center jumbotron bg-info">
        <div class="text-center text-white mt-2 pt-1">
            <h1><i class="fab fa-telegram fa-lg pr-3"></i>みんなの大喜利「GiriGiri」</h1>
        </div>
    </div>
    <h5 class="text-center mb-5">「GiriGiri」は無料で楽しめるネット大喜利。<br>ユーザー登録すると<br>お題・ボケ投稿やワロタ・フォローもできます。</h5>
    <div class="w-75 m-auto">@include('commons.error_messages')</div>
    @if (Auth::check())
    <div class="text-center mb-3">
        <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="text" rows="4" placeholder="お題を入力してください">{{ old('text') }}</textarea>
                <div class="text-left mt-3">
                    <button type="submit" class="btn btn-primary">お題を投稿する</button>
                </div>
            </div>
        </form>
    </div>
    @endif
    <h1 class="text-center mb-3">《 お 題 》</h1>
    @include('posts.posts',['posts' => $posts])
@endsection

<!-- 投稿フォームに説明文を表示、文字が入力されると消える -->
<script>
    var textarea = document.querySelector('textarea[name="text"]');
    var placeholderText = textarea.getAttribute('placeholder');

    textarea.addEventListener('focus', function() {
        if (textarea.value === placeholderText) {
            textarea.value = '';
        }
    });

    textarea.addEventListener('blur', function() {
        if (textarea.value === '') {
            textarea.value = placeholderText;
        }
    });
</script>