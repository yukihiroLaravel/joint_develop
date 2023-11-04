@extends('layouts.app')

@section('content')
@include('replies.partials_show', ['post' => $post])
        <form method="post" action="{{ route('replies.store', $post) }}">
            @csrf
            <div class="form-group">
                <textarea name="content" id="content" class="form-control" rows="4" required placeholder="リプライを入力"></textarea>
            </div>
            <button type="submit" class="btn btn-primary float-right">投稿</button>
        </form>
@endsection