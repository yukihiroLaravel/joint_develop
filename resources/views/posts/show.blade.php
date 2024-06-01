@extends('layouts.app')
@section('content') 
<button class="btn btn-info btn-sm mr-2">詳細詳細</button>
<p class="mb-2 post-content">{{ $post->content }}</p><!-- 投稿内容を表示 -->
<p class="text-muted">{{ $post->created_at }}</p><!-- 投稿日時を相対時間表記で表示  -->
<a href="{{ route('top') }}" class="btn btn-secondary" onclick='window.history.back(-1);'><戻る</a><!-- ユーザ詳細画面に戻る -->
@endsection