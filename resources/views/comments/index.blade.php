@extends('layouts.app')
@section('content')
@include('commons.success')
<div class="center jumbotron bg-info">
    <div class="text-center text-white mt-2 pt-1">
        <h1><i class="fab fa-telegram fa-lg pr-3"></i>みんなの大喜利「GiriGiri」</h1>
    </div>
</div>
<h1 class="text-center mb-3">《新着ボケ》</h1>
@include('comments.comment_list')
<div class="m-auto" style="width: fit-content">{{ $comments->links('pagination::bootstrap-4') }}</div>
@endsection