@extends('layouts.app')

@section('content')
    <h2 class="mt-5">投稿を編集する</h2>
    <form method="POST" action="{{ route('post.update', $post->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <textarea
                id="content"
                class="form-control"
                name="content"
                rows="5"
            >{{ old('content', $post->content) }}</textarea>

            @error('content')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        @include('commons.tag_autocomplete', [
            'tagValue' => old(
                'tags',
                $post->tags->pluck('name')->implode(', ')
            ),
        ])

        <button type="submit" class="btn btn-primary">
            更新する
        </button>
    </form>
@endsection