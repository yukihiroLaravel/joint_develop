@php
    if (!isset($divContainerStyle)) {
        $divContainerStyle = '';
    }

    if (!isset($enableVideoFlg)) {
        $enableVideoFlg = 'OFF';
    }

    // 1ファイルあたりの最大アップロードサイズ(単位:MB)
    $uploadMaxFilesize = config('app.uploadMaxFilesize');

    // 画像の場合の仕様で決めたアップロードの最大サイズ(単位:MB)
    $uploadImageMaxFilesize = config('app.uploadImageMaxFilesize');
@endphp
<div class="container" {!! $divContainerStyle !!}>
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
            } else if (isset($user)) {
                $baseId = $user->id;
            } else {
                throw new \Exception("編集時の基礎情報がありません");
            }
        @endphp
        <input id="file-upload-baseId" type="hidden" value="{{ $baseId }}" />
    @endif

    {{-- アップロードする画像タイプ --}}
    <input id="file-upload-imageType" type="hidden" value="{{ $imageType }}" />

    {{-- 動画のアップロードが可能なモードかどうか --}}
    <input id="enable-video-flg" type="hidden" value="{{ $enableVideoFlg }}" />

    {{-- 1ファイルあたりの最大アップロードサイズ(単位:MB) --}}
    <input id="upload-max-file-size" type="hidden" value="{{ $uploadMaxFilesize }}" />

    {{-- 画像の場合の仕様で決めたアップロードの最大サイズ(単位:MB) --}}
    <input id="upload-image-max-file-size" type="hidden" value="{{ $uploadImageMaxFilesize }}" />

    {{-- バリデーションエラー時に動的作成UI部の復元すべきかの判定のため前回値の有無の判定用 --}}
    {{-- サーバーに一回送って、それが返ってくるかで前回値の有無を判定するためname属性を指定している。 --}}
    <input name="fileUploadSubmitFlg" type="hidden" value="ON" />

    {{-- アップロードUIの復元モードであるかどうかのフラグ --}}
    <input id="file-upload-ui-restore-mode-flg" type="hidden" value="OFF" />

    {{-- アップロードUIの「さらに、バリデーションエラー時の」復元モードであるかどうかのフラグ --}}
    <input id="file-upload-ui-restore-for-validate-error-mode-flg" type="hidden" value="OFF" />
</div>

@php
    /*
        sessionStorage.removeItem()をするかどうかのフラグ

        前のsessionStorageが残ってることによる誤作動を防ぎたいため確実に制御したい
        一旦、ここでtrueで定義しておき、やってはまずい制御パスのときだけ、falseにすることで
        すべきときに確実に、なされるように制御する。
        完全性を担保するために、「if, else」が複雑にからんだケースに一個一個、
        「sessionStorage.removeItem()」を実装していく形を避けたいため、やりたくないケースだけfalseを指定し
        下のほうでtrueの時だけやるという形にして、完全性を担保したい。そのために使うフラグ。
    */
    $isSessionStorageRemoveItem = true;
@endphp

@if (old('fileUploadSubmitFlg'))
    {{-- old('fileUploadSubmitFlg')が値ありと判定されるのは、バリデーションエラー時の時だけである --}}
    {{--    この判定のために、name属性を'fileUploadSubmitFlg'としたhiddenタグを置いてる。 --}}

    {{-- バリデーションエラー時の再表示の場合 --}}

    @php
        // このケースでは、sessionStorage.removeItem()をしたくないのでfalseを指定
        $isSessionStorageRemoveItem = false;
    @endphp

    <script>
        // 「アップロードUIの復元モードである」と、フラグをたてる
        $('#file-upload-ui-restore-mode-flg').val('ON');

        // 「アップロードUIの「さらに、バリデーションエラー時の」復元モードである」と、フラグをたてる
        $('#file-upload-ui-restore-for-validate-error-mode-flg').val('ON');
    </script>
@else
    {{-- 上記以外の「通常」の場合 --}}
    @if ($editFlg === 'ON')
        @php
            if (isset($post)) {
                $loadInfo = $post->getLoadInfoForEditPostInitial();
            } else if (isset($user)) {
                $loadInfo = $user->getLoadInfoForEditUserInitial();
            } else {
                throw new \Exception("編集時の初期表示のロードに必要な情報の引数指定がありません");
            }
        @endphp
        @if (!is_null($loadInfo))

            @php
                // このケースでは、sessionStorage.removeItem()をしたくないのでfalseを指定
                $isSessionStorageRemoveItem = false;
            @endphp

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
    @endif
@endif

@if ($isSessionStorageRemoveItem)
    {{-- sessionStorage.removeItem()をすべき場合 --}}
    <script>
        // sessionStorageから削除する処理
        sessionStorage.removeItem('uploadUiRestoreInfoFileUuids');
        sessionStorage.removeItem('uploadUiRestoreInfoFileNames');
    </script>
@endif

<script src="{{ asset('js/upload.js') }}"></script>
