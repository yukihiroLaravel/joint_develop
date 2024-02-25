@extends('layouts.app')
@section('content')

    <h2 class="mt-5">投稿を編集する</h2>
    @include('commons.error_messages')
    @php
        $content = $post->content;
    @endphp
    <form method="POST" action="{{ route('post.update',$content)}}">
            @csrf
            @method('PUT')
                <div class="form-group">
                <textarea id="content" class="form-control" name="content" rows="{{ old('content', $post->content)}}"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">更新する</button>
    </form>
@endsection