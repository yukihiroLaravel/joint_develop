@extends('layouts.app')
@section('content') 
<h2 class="mt-5">投稿詳細</h2>
<div>
    <p class="mb-2 post-content">{{ $post->content }}</p><!-- 投稿内容を表示 -->
    <p class="text-muted">{{ $post->created_at }}</p><!-- 投稿日時を相対時間表記で表示  -->
    <a href="{{ route('top') }}" class="btn btn-primary">戻る</a> <!-- ユーザ詳細画面に戻る --> 
</div> 
@endsection