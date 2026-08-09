@extends('layouts.app')

@section('content')
    <h2 class="mt-5">投稿を編集する</h2>
    <form method="POST" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <textarea id="content" class="form-control js-character-count" name="content" rows="5">{{ old('content', $post->content) }}
            </textarea>

            <div class="text-right mt-1">
                <small>
                    <span class="js-character-count-display">{{ mb_strlen(old('content', $post->content)) }}</span> / 140文字
                </small>
            </div>

            <div class="js-character-count-error alert alert-danger mt-2" style="display: none;"></div>

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

        <div class="form-group border rounded p-3 bg-light">
            <label class="font-weight-bold">添付画像</label>

            @if ($post->image_path)
                <div class="mb-3">
                    <p class="small text-muted mb-1">現在の画像:</p>
                    <img
                        src="{{ asset('storage/' . $post->image_path) }}"
                        alt="現在の添付画像"
                        class="img-fluid rounded border bg-white mb-2"
                        style="max-height: 150px; width: auto; object-fit: contain;"
                    >
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="delete_image" id="delete_image" value="1">
                        <label class="form-check-label text-danger font-weight-bold" for="delete_image">
                            この画像を削除する
                        </label>
                    </div>
                </div>
            @endif

            <div class="mt-2">
                <label for="image" class="small text-muted mb-1">
                </label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
            </div>

            @error('image')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            更新する
        </button>
    </form>
@endsection