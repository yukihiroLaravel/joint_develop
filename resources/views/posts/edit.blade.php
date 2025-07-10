@extends('layouts.app')
@section('content')
    <h2 class="mt-5 mb-5">投稿を編集する</h2>
    @include('components.flash_message')    
    <form method="POST" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data"> 
        @csrf
        @method('PUT')
        <div class="form-group mt-5">
            <textarea id="content" class="form-control" name="content" rows="5">{{ old('content', $post->content) }}</textarea>
        </div>

        {{-- タグの選択 --}}
        <div class="form-group mt-4">
            <label>タグを選択：</label><br>
            @foreach ($tags as $tag)
                <label class="mr-3">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                        {{ in_array($tag->id, $selectedTagIds ?? []) ? 'checked' : '' }}>
                    {{ $tag->name }}
                </label>
            @endforeach
        </div>

        <input type="hidden" name="redirect_to" value="{{ url()->previous() }}">
        
        <button type="submit" class="btn btn-primary mt-5 mb-5">更新する</button>
        {{-- 画像の表示 --}}
        @if ($post->image_path)
            <div class="mt-4">
                <p>現在の画像：</p>
                <div class="d-flex align-items-center">
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="投稿画像" style="max-width: 100px;">
                </div>
            </div>
        @endif

        {{-- 画像のアップロード --}}
        <div class="form-group mt-4">
            <label class="d-block mb-2">画像を変更する</label>
            <div class="d-flex align-items-center justify-content-between mt-4 mb-2">
                <div class="d-flex align-items-center mb-2">
                    {{-- アイコン --}}
                    <label for="image" style="cursor: pointer;" class="mb-0 mr-2 d-flex align-items-center">
                        <img src="{{ asset('images/icons/写真アイコン4.png') }}" alt="画像を選択" style="width: 32px; height: 32px;">
                    </label>
                    {{-- ファイル名表示 --}}
                    <span id="file-name" class="text-muted" style="font-size: 0.9rem; line-height: 32px; height: 32px;"></span>
                </div>
                <input type="file" name="image" id="image" class="d-none" accept="image/*">
                {{-- プレビュー画像 --}}
                <img id="preview" src="#" alt="画像プレビュー" class="img-fluid mb-1" style="display: none; max-height: 100px;">

                <div class="d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">更新する</button>
                </div>
            </div>
        </div>
    </form>
    {{-- 画像削除フォーム --}}
    <form action="{{ route('post.image.destroy', $post->id) }}" method="POST" onsubmit="return confirm('画像を削除してもよろしいですか？');" class="mt-2">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-light p-1" title="削除">
            <img src="{{ asset('images/icons/ゴミ箱のアイコン素材.png') }}" alt="削除" style="width: 20px; height: 20px;">
        </button>
    </form>
@endsection

{{-- 画像プレビュー用 JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('image');
    const preview = document.getElementById('preview');
    const fileNameDisplay = document.getElementById('file-name');

    if (input) {
        input.addEventListener('change', function (event) {
            const file = event.target.files[0];

            if (file && file.type.startsWith('image/')) {
                fileNameDisplay.textContent = '選択されたファイル: ' + file.name;

                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                preview.src = '#';
                fileNameDisplay.textContent = '';
            }
        });
    }
});
</script>
