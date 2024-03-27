@extends('layouts.app')
@section('content')
    <h2 class="mt-5">投稿を編集する</h2>
    @include('commons.error_messages')
    <form method="POST" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <textarea id="content" class="form-control" name="content" rows="5">{{ old('content', $post->content) }}</textarea>
            <div class="d-flex flex-column mt-3" style="row-gap: 0.5rem">
                <ul class="postImg-input_container d-flex flex-wrap align-items-center list-unstyled mb-0 col">
                    @foreach ($post->postImages as $postImage)
                        <li class="postImg-input_item col-md-3 col-6">
                            <div class="currentImg_preview_unit">
                                <button class="postImg_delete"><i class="fa-solid fa-xmark"></i></button>
                                <img src="{{ asset('storage/images/postImgs/' . $postImage->image_name) }}" alt="画像プレビュー"
                                    class="mb-2 currentImg_preview" id="{{ $postImage->id }}">
                            </div>
                            <div class="postImg_preview_unit d-none">
                                <button class="postImg_delete"><i class="fa-solid fa-xmark"></i></button>
                                <img src="" alt="画像プレビュー" class="postImg_preview mb-2">
                            </div>
                            <label class="btn">
                                <i class="fas fa-image"></i>
                                <p class="mb-0">変更</p>
                                <input type="file" name="postImgs[]" accept=".png, .jpg, .jpeg" class="postImgInput"
                                    value="" hidden>
                            </label>
                        </li>
                    @endforeach
                    @if ($post->postImages->count() < 4)
                        <li class="postImg-input_item col-md-3 col-6">
                            <div class="postImg_preview_unit d-none">
                                <button class="postImg_delete"><i class="fa-solid fa-xmark"></i></button>
                                <img src="" alt="画像プレビュー" class="postImg_preview mb-2">
                            </div>
                            <label class="btn">
                                <i class="fas fa-image"></i>
                                <p class="mb-0">追加</p>
                                <input type="file" name="postImgs[]" accept=".png, .jpg, .jpeg" class="postImgInput"
                                    hidden>
                            </label>
                        </li>
                    @endif
                </ul>
                <input type="hidden" name="deleteImg" value=" ">
                <button type="submit" class="ml-auto btn btn_accent-color">更新する</button>
            </div>
        </div>


    </form>
@endsection
