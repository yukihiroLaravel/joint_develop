@extends('layouts.app')
@section('content')
    <div class="text-center mb-3" style="background: url('/images/camp-bg.jpg') no-repeat center center; background-size: cover; border-radius: 15px; padding: 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">>
        <div class="d-inline-block w-75 text-left bg-light p-4 rounded shadow" style="background-color: rgba(255, 255, 255, 0.9);">
            <h2 class="text-left mt-3 mb-4" style="color:#2e5c2b; font-weight:bold;">
                <i class="fas fa-edit"></i> 投稿を編集する
            </h2>
            <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data" class="d-inline-block w-100">
                @csrf
                @method('PUT')
                @include('commons.error_messages')
                <div class="form-group">
                    <label for="content" class="font-weight-bold text-dark">内容</label>
                    <textarea id="content" class="form-control border border-success" name="content" rows="5" style="border-radius: 10px;">{{ old('content', $post->content) }}</textarea>
                    {{-- タグ入力 --}}
                    <label for="tags" class="mt-3 font-weight-bold text-dark">タグ</label>
                    <input type="text" 
                        id="tags" 
                        name="tags" 
                        class="form-control border border-success"
                        style="border-radius: 10px;"
                        placeholder="カンマ区切りで入力（例: キャンプ, BBQ, アウトドア）"
                        value="{{ old('tags', $post->tags->pluck('name')->implode(', ')) }}">
                    @if($post->images->count() > 0)
                        <div class="mt-4">
                            <p class="font-weight-bold text-dark"><i class="fas fa-images"></i>>現在の画像:</p>
                            <div class="d-flex flex-wrap">
                                @foreach($post->images as $image)
                                    <div class="mr-3 mb-3 text-center p-2" style="background:#f9f7f1; border:2px solid #8b5e3c; border-radius:10px;">
                                        <img src="{{ asset('storage/' . $image->file_path) }}" 
                                            alt="投稿画像" 
                                            style="width:120px; height:auto; border-radius:8px; display:block; box-shadow: 2px 2px 6px rgba(0,0,0,0.2);">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" 
                                                type="checkbox" 
                                                name="delete_images[]" 
                                                value="{{ $image->id }}" 
                                                id="delete_image_{{ $image->id }}">
                                            <label class="form-check-label small text-muted" for="delete_image_{{ $image->id }}">
                                                この画像を削除
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <label for="images" class="mt-3 font-weight-bold text-dark">画像を追加する</label>
                    <input type="file" name="images[]" multiple class="form-control-file mt-2">
                    <div class="text-left mt-4">
                        <button type="submit" class="btn btn-success shadow-sm" style="border:2px solid #2e5c2b; font-weight:bold; border-radius: 10px; padding: 8px 20px;">
                            <i class="fas fa-check"></i> 更新する
                        </button>
                    </div>  
                </div>
            </form>
        </div>     
    </div>        
@endsection