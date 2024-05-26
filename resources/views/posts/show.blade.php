@extends('layouts.app')
@section('content') 
<h2 class="mt-5">投稿詳細</h2>
<p class="mb-2 post-content">{{ $post->content }}</p><!-- 投稿内容を表示 -->
<p class="text-muted">{{ $post->created_at }}</p><!-- 投稿日時を相対時間表記で表示  -->
<a href="#" class="btn btn-secondary" onclick='window.history.back(-1);'><戻る</a>

@endsection