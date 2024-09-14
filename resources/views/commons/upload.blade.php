<div class="container">
    <div id="file-upload-container" style="margin: 20px;"></div>

    {{-- アップロード済の画像をクライアントサイドでサムネイル表示のためhrefに指定するURLのベース部分 --}}
    <input id="file-upload-base-path" type="hidden" value="{{ asset('storage') }}" />

    {{-- 複数画像アップロードかどうかのフラグ値 --}}
    <input id="file-upload-multiFlg" type="hidden" value="{{ $multiFlg }}" />
    
    {{-- 編集かどうかのフラグ値 --}}
    <input id="file-upload-editFlg" type="hidden" value="{{ $editFlg }}" />
    @if ($editFlg === 'ON')
        @php
            if (isset($post)) {
                $baseId = $post->id;
            } else {
                throw new \Exception("編集時の基礎情報がありません");
            }
        @endphp
        <input id="file-upload-baseId" type="hidden" value="{{ $baseId }}" />
    @endif

    {{-- アップロードする画像タイプ --}}
    <input id="file-upload-imageType" type="hidden" value="{{ $imageType }}" />

    {{-- バリデーションエラー時に動的作成UI部の復元すべきかの判定のため前回値の有無の判定用 --}}
    {{-- サーバーに一回送って、それが返ってくるかで前回対の有無を判定するためname属性を指定している。 --}}
    <input name="fileUploadSubmitFlg" type="hidden" value="ON" />

    {{-- アップロードUIの復元モードであるかどうかのフラグ --}}
    <input id="file-upload-ui-restore-mode-flg" type="hidden" value="OFF" />
</div>
@if (!session('submitSuccess') && old('fileUploadSubmitFlg'))
    {{-- 'submitSuccess'の値がない、つまり、submit成功時でない --}}
    {{-- かつ、 --}}
    {{-- 'fileUploadSubmitFlg'の値がある、つまり、前回値がありバリデーションエラー時である --}}
    <script>
        // 「アップロードUIの復元モードである」と、フラグをたてる
        $('#file-upload-ui-restore-mode-flg').val('ON');
    </script>
@else
    {{-- 上記以外の「通常」の場合 --}}
    @if ($editFlg === 'ON')
        @php
            if (isset($post)) {
                $loadInfo = $post->getLoadInfoForEditPostInitial();
            } else {
                throw new \Exception("編集時の初期表示のロードに必要な情報の引数指定がありません");
            }
        @endphp
        @if (!is_null($loadInfo))
            <input id="file-upload-ui-load-info-fileUuids" type="hidden" value="{{ $loadInfo->fileUuids }}" />
            <input id="file-upload-ui-load-info-fileNames" type="hidden" value="{{ $loadInfo->fileNames }}" />

            <script src="{{ asset('js/upload_ui_info_prepare.js') }}"></script>
            <script>
                /*
                    $loadInfoがDB値より取得したアップロードUI部分を復元するための
                    json形式の情報なので、
                    「アップロードUIの復元モードである」と、フラグをたてて
                    $loadInfoの内容をsessionStorageに保存しておけば
                    upload.js側の復元処理にて、DB値より取得した情報で
                    アップロード済のファイルの情報でアップロードUI部分を復元することになる。
                */

                // 「アップロードUIの復元モードである」と、フラグをたてる
                $('#file-upload-ui-restore-mode-flg').val('ON');

                prepareUploadUIInfo();
            </script>
        @endif
    @else
        <script>
            // sessionStorageから削除する処理
            sessionStorage.removeItem('uploadUiRestoreInfoFileUuids');
            sessionStorage.removeItem('uploadUiRestoreInfoFileNames');
        </script>
    @endif
@endif
<script src="{{ asset('js/upload.js') }}"></script>
