@extends('layouts.app')
@section('content')
    <div class="text-center mb-3">
        <div class="d-inline-block w-75 text-left">
            <h2 class="text-left mt-3">投稿を編集する</h2>
            <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data" class="d-inline-block w-75">
                @csrf
                @method('PUT')
                @include('commons.error_messages')
                <div class="form-group">
                    <textarea id="content" class="form-control" name="content" rows="5">{{ old('content', $post->content) }}</textarea>    
                    @if($post->images->count() > 0)
                        <div class="mt-3">
                            <p>現在の画像:</p>
                            <div class="d-flex flex-wrap">
                                @foreach($post->images as $image)
                                    <div class="mr-3 mb-3 text-center">
                                        <img src="{{ asset('storage/' . $image->file_path) }}" 
                                            alt="投稿画像" 
                                            style="width:120px; height:auto; border-radius:5px; display:block;">
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" 
                                                type="checkbox" 
                                                name="delete_images[]" 
                                                value="{{ $image->id }}" 
                                                id="delete_image_{{ $image->id }}">
                                            <label class="form-check-label" for="delete_image_{{ $image->id }}">
                                                この画像を削除
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <input type="file" name="images[]" multiple class="form-control-file mt-2">
                    <div class="text-left mt-3">
                        <button type="submit" class="btn btn-primary">更新する</button>
                    </div>  
                </div>
            </form>
        </div>     
    </div>        
@endsection