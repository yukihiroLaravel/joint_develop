@extends('layouts.app')
@section('content')
    <div class="center jumbotron bg-gradient-info text-white py-5" style="background: linear-gradient(45deg, #bb2f5b 0%, #165ab3 100%);">
        <div class="text-center mt-2 pt-1">
            <h1 style="font-family: 'Poppins', sans-serif; font-size: 48px;">
                <i class="fas fa-camera-retro fa-lg pr-3"></i>Hobby Posts
            </h1>
        </div>
    </div>
    <h5 class="text-center mb-3 subtitle">
        お気に入りの趣味について、画像や動画で共有しよう！
    </h5>
    <div class="w-75 m-auto">
        @include('commons.error_messages')
        @if (session('status'))
            <div class="alert alert-success mt-3">
                {{ session('status') }}
            </div>
        @endif
    </div>
    <div class="text-center mb-3">
        <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75" enctype="multipart/form-data" id="postForm">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="post" rows="3" value="{{ old('post') }}" placeholder="投稿内容を入力..." style="border: 1px solid #ddd; border-radius: 5px;"></textarea>
                <div class="form-group mt-4">
                    <label for="image" class="font-weight-bold">画像または動画を選択
                        <small id="size-limit-text" class="text-muted font-weight-light"></small>
                    </label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image" accept="image/*,video/mp4">
                            <label class="custom-file-label" for="image" data-browse="参照">ファイルを選択(ここにドロップすることもできます)</label>
                        </div>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary input-group-text" id="inputFileReset">取消</button>
                        </div>
                    </div>
                </div>

                {{-- スタイリッシュなトグルスイッチ --}}
                <div class="form-group d-flex justify-content-start align-items-center">
                    <label class="mr-3" for="scheduleToggle">予約投稿</label>
                    <label class="switch">
                        <input type="checkbox" id="scheduleToggle">
                        <span class="slider"></span>
                    </label>
                </div>

                {{-- 折りたたみの予約投稿日時フィールド（初期は非表示） --}}
                <div class="form-group" id="scheduledAtContainer" style="display: none;">
                    <input type="datetime-local" name="scheduled_at" class="form-control" id="scheduledAt" min="">
                </div>

                <div class="text-left mt-4 mb-10">
                    <button type="submit" class="btn btn-primaryX btn-lg btn-block" style="border-radius: 50px;">投稿する</button>
                </div>
            </div>
        </form>
        @include('posts.posts', ['posts' => $posts])
    </div>

    <style>
        /* トグルスイッチのスタイル */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background: linear-gradient(45deg, #ff2a6d 0%, #4294ff 100%);
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
    <script>
        bsCustomFileInput.init();

        const uploadMaxSize = '{{ $uploadMaxSize }}';

        // サイズ制限を表示
        document.getElementById('size-limit-text').innerText = `(jpeg,png,jpg,gif,mp4 最大${uploadMaxSize}B)`;

        // ファイル選択キャンセル機能
        document.getElementById('inputFileReset').addEventListener('click', function() {
            const elem = document.getElementById('image');
            elem.value = '';
            const clone = elem.cloneNode(false);
            elem.parentNode.replaceChild(clone, elem);
            bsCustomFileInput.init();
        });

        // サイズ文字列をバイトに変換する関数
        function convertSizeToBytes(size) {
            // 末尾の文字を取得して単位を判定（'B', 'K', 'M', 'G' など）
            const unit = size.slice(-1).toLowerCase();
            // 数値部分を取得して整数に変換（例: '10M' -> 10）
            const sizeValue = parseInt(size);

            switch (unit) {
                case 'g':
                    return sizeValue * 1024 * 1024 * 1024; // GB
                case 'm':
                    return sizeValue * 1024 * 1024; // MB
                case 'k':
                    return sizeValue * 1024; // KB
                default:
                    return sizeValue; // B
            }
        }

        // upload_max_size に基づくファイルサイズチェック
        document.getElementById('image').addEventListener('change', function() {
            const file = this.files[0];
            const maxSizeBytes = convertSizeToBytes(uploadMaxSize); // 単位に応じたバイト数に変換

            if (file && file.size > maxSizeBytes) {
                alert(`ファイルサイズが ${uploadMaxSize}B を超えています。別のファイルを選択してください。`);
                this.value = '';
                bsCustomFileInput.destroy();
                bsCustomFileInput.init();
            }
        });

        // 過去の日付を選択できないようにする処理
        const scheduledAt = document.getElementById('scheduledAt');
        
        // 現在の日本時間（JST）を取得
        const now = new Date();
        const jstNow = new Date(now.getTime() + (9 * 60 * 60 * 1000)); // UTC+9 に変換
        
        // 日本時間を ISO 形式（yyyy-MM-ddTHH:mm）にフォーマット
        const jstFormatted = jstNow.toISOString().slice(0, 16); 
        
        // min属性に現在の日時をセット（過去の日時は選択不可）
        scheduledAt.min = jstFormatted;

        const scheduleToggle = document.getElementById('scheduleToggle');
        const scheduledAtContainer = document.getElementById('scheduledAtContainer');

        scheduleToggle.addEventListener('change', function() {
            if (this.checked) {
                scheduledAtContainer.style.display = 'block';
            } else {
                scheduledAtContainer.style.display = 'none';
            }
        });

        document.getElementById('postForm').addEventListener('submit', function(event) {
            if (scheduleToggle.checked && scheduledAt.value < jstFormatted) {
                alert('過去の日付は選択できません。');
                event.preventDefault();
            }
        });
    </script>
@endsection
