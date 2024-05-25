@extends('layouts.app')
@section('content')
<div class="text-center mb-3">
    <dl>
        <dt>コメント:</dt>
        <dd>{{ $comment->id }}</dd>
        <dt>content</dt>
        <dd>{{ $comment->content }}</dd>
    </dl>
</div>
        
@endsection
