@extends('layouts.app')

@section('content')
    <h2 class="mt-5">投稿を編集する</h2>
    <form method="POST" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <textarea id="content" class="form-control js-character-count" name="content" rows="5" data-max-length="100">{{ old('content', $post->content) }}</textarea>

            <div class="text-right mt-1">
                <small>
                    <span class="js-character-count-display">{{ mb_strlen(old('content', $post->content)) }}</span> / 100文字
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
                <div id="drop-area" class="border rounded p-4 text-center bg-light" style="cursor:pointer;">
                    <p class="mb-2">📷</p>
                    <p class="mb-1">
                        ここに画像をドラッグ＆ドロップ
                    </p>
                    <small class="text-muted">
                        またはクリックして画像を選択
                    </small>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/*"
                        hidden
                    >
                </div>

                <div class="text-center mt-3">
                    <img
                        id="preview"
                        class="img-fluid d-none"
                        style="
                            width:100%;
                            max-width:500px;
                            height:300px;
                            object-fit:contain;
                        "
                    >

                    <div class="mt-2">
                        <button
                            type="button"
                            id="remove-image"
                            class="btn btn-sm btn-outline-danger d-none"
                        >
                            × 画像を削除
                        </button>
                    </div>
                </div>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const dropArea = document.getElementById('drop-area');
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('preview');
    const removeButton = document.getElementById('remove-image');

    if (!dropArea || !imageInput || !preview || !removeButton) {
        return;
    }

    dropArea.addEventListener('click', function () {
        imageInput.click();
    });

    imageInput.addEventListener('change', function () {
        if (this.files.length > 1) {
            alert('画像は1枚だけ選択してください。');
            this.value = '';
            return;
        }

        previewImage(this.files[0]);
    });

    function previewImage(file) {
        if (!file) return;

        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            removeButton.classList.remove('d-none');
        };

        reader.readAsDataURL(file);
    }

    dropArea.addEventListener('dragover', function (e) {
        e.preventDefault();
        dropArea.classList.add('border-primary');
    });

    dropArea.addEventListener('dragleave', function () {
        dropArea.classList.remove('border-primary');
    });

    dropArea.addEventListener('drop', function (e) {
        e.preventDefault();

        dropArea.classList.remove('border-primary');

        const files = e.dataTransfer.files;

        if (files.length > 1) {
            alert('画像は1枚だけ選択してください。');
            return;
        }   

        if (files.length === 1) {
            imageInput.files = files;
            previewImage(files[0]);
        }
    });

    removeButton.addEventListener('click', function () {
        imageInput.value = '';
        preview.src = '';
        preview.classList.add('d-none');
        removeButton.classList.add('d-none');
    });

});
</script>
@endpush