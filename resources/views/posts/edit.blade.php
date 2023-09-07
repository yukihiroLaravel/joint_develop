@extends('layouts.app')
@section('content')
<h2 class="mt-5">投稿を編集する</h2>
    <form method="POST" action="{{ route('post.update', $post->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group mt-5">
            <div class="form-group">
            @include('commons.error_messages')
                <textarea id="text" class="form-control" name="text" rows="6">{{ old('text', $post->text) }}</textarea>
            </div>
            <div class="w-75 m-auto">
            @if (session('postsDestroyMessage'))
            <div class="alert alert-success text-center">
                {{ session('postsDestroyMessage') }}
            </div> 
            @endif
    </div>        
            <button type="submit" class="btn btn-primary">更新する</button>
        </div>
    </form>
@endsection
