// 動的にファイルアップロードUIを追加する関数
function createFileUpload() {
    /*
        同じnameを持つ複数のinput要素が存在すると、nameに[]をつけて複数送信できる状況にして
        サーバー側でその値が配列として送信されるようにする。
        fileUuids[]、fileNames[]のname属性を指定し、
        submit時のリクエストに乗せれる形にする
    */
    const fileUploadHtml = `
        <div class="file-upload-wrapper d-flex align-items-center" style="margin-bottom: 20px;">
            <input name="fileUuids[]" class="file-uuid" type="hidden" value=""/>
            <input name="fileNames[]" class="file-name" type="hidden" value=""/>
            <img src="" class="thumbnail" style="display:none; margin-top: 10px; width: 150px; height: 100px;" />
            <button class="btn btn-danger delete-file mr-2" style="display:none; min-width: 100px; margin-left: 10px">画像削除</button>

            <div class="fileInputDiv">
                <input type="file" class="form-control-file file-input mr-2" style="display:none" />
                <button class="btn btn-info file-input-button mr-2" onclick="fileInputButton(event); return false;" style="min-width: 100px; margin-left: 10px">画像追加</button>
            </div>

            <span class="file-name-label mr-2" style="display:none;"></span>
        </div>
    `;
    $('#file-upload-container').append(fileUploadHtml);
}

/*
    「 <input type="file" 」のデフォルトのデザインがよくないため、
    それを、style="display:none" で消しといて、
    代わりに、class属性値を「file-input-button」にした<buttonを置いて、
    そのclickイベントハンドラを当functionとして、そこで、
    「 <input type="file" 」をclick()する方式にして
    画像追加のボタンをカスタマイズした。
    そのための、clickイベントハンドラを当functionである。
*/
function fileInputButton(event) {
    /*
        $('.file-input').click();をしてしまうと、複数の.file-inputが反応し、挙動不審となったため、
        最も近い親の「.file-upload-wrapper」からたどって、.file-inputを1個に特定したうえで、
        click()する形とした。
    */
    event.preventDefault();
    $(event.target).closest('.file-upload-wrapper').find('.file-input').click();
}

// fileWrapperをupload完了済のUI状態にする
function changeCompleteFileWrapper(param) {
    /*
        param.fileWrapper.find('.file-input-button').hide();
        をやっても、なぜか、非表示にならず、
        <div>タブで囲ってそれごと、非表示にしたら消えた
    */
    param.fileWrapper.find('.fileInputDiv').hide();

    /*
        「 <input type="file" 」の要素について、ただ表示を消しても
        disabledがfalseであれば、親要素のformがsubmitされるときに
        選択しているファイルの中身をリクエストにのせて送信してしまう。

        アップロード自体は、ajax通信で完了させる実装で、
        当「 <input type="file" 」はファイルの選択や、選択イベント発火、
        選択したファイルの中身のjavascriptコードでの取得(ajaxの送信データとして指定のため)
        に使っているだけである。

        submit通信時にファイルの中身をリクエストにのせる用途では、当実装では使いたくない。

        それは、submit時の無駄な通信であり、パフォーマンス低下を招くから避けたい。
        また、それだけではなく、
        通信サイズの最大値などの環境設定の調査や、動作確認時での
        起きた事象に対する原因調査や、特定の「やりやすさ／やりにくさ」にも
        影響がでると予想される。
        
        そのため、disabledをtrueにしておく。
    */
    param.fileWrapper.find('.file-input').prop('disabled', true);

    let fileNameLabel = param.fileWrapper.find('.file-name-label');
    fileNameLabel.text(param.fileName);
    fileNameLabel.show();

    param.fileWrapper.find('.delete-file').show();

    // サムネイル画像を表示
    const filePath = $('#file-upload-base-path').val() + '/' + param.filePath;
    param.fileWrapper.find('.thumbnail').attr('src', filePath).show();

    param.fileWrapper.find('.file-uuid').val(param.uuid);
    param.fileWrapper.find('.file-name').val(param.fileName);
}

/*
    リクエストでサーバー送信対象であるにも関わらず、sessionStorageを使った復元処理とした経緯の説明
    
    リクエストに
    fileUuids[]、fileNames[]のname属性を指定し、
    submit時のリクエストに乗せれる形にしているのだから
        <input id="oldFileUuids" type="hidden" name="fileUuids" value="{{ json_encode(old('fileUuids', [])) }}">
        <input id="oldFileNames" type="hidden" name="fileNames" value="{{ json_encode(old('fileNames', [])) }}">
    のような形でサーバーからの戻り値で、バリデーションエラー時の復元処理を
    最初は、試みていた

    しかし、テキスト値未入力で「投稿する」ボタンを何回も押して
    バリデーションエラーでの再表示を何度も行い
    何度も、復元処理がうまく動作するかを確認していたところ
    
    1回目の復元時は、
        $('#oldFileUuids').val()
        '["fb104f6a-2b4f-4472-8757-bb249bac81da","2dde6b1a-b695-4efe-bdd2-539ca880db8c",null]'
        $('#oldFileNames').val()
        '["imageP.jpg","image1.png",null]'

    2回目の復元時は、
        $('#oldFileUuids').val()
        '"[\\"fb104f6a-2b4f-4472-8757-bb249bac81da\\",\\"2dde6b1a-b695-4efe-bdd2-539ca880db8c\\",null]"'
        $('#oldFileNames').val()
        '"[\\"imageP.jpg\\",\\"image1.png\\",null]"'

    の形となって、この影響により、2回目の復元時に挙動がおかしくなった

    投稿ボタンを押す前のhtml状態と、1回目の復元した後の
    fileUuidsと、fileNamesの付近でのhtmlの値が完全一致しているのにも関わらずである

    配列をサーバーに投げて、old()で受け取るとおかしくなるのかもしれない
    エスケープが原因かと思い
        <input id="oldFileUuids" type="hidden" name="fileUuids" value="{{ json_encode(old('fileUuids', [])) }}">
        <input id="oldFileNames" type="hidden" name="fileNames" value="{{ json_encode(old('fileNames', [])) }}">
    ではなく
        <input id="oldFileUuids" type="hidden" name="fileUuids" value="{!! json_encode(old('fileUuids', [])) !!}">
        <input id="oldFileNames" type="hidden" name="fileNames" value="{!! json_encode(old('fileNames', [])) !!}">
    を試みたが、これだとhiddenの値に、きちんとした値が入らず
    復元処理が誤動作をした。

    そこで、

    2回目を1回目のイメージの値に変換して対処してみたら、2回の復元は正常動作したが、
    3回目に
        $('#oldFileUuids').val()
        '"\\"[\\\\\\"35069164-c410-4833-ac90-821615383f25\\\\\\",\\\\\\"4638ee3e-f252-4e26-abdd-23210ac493e9\\\\\\",null]\\""'
        $('#oldFileNames').val()
        '"\\"[\\\\\\"imageP.jpg\\\\\\",\\\\\\"imageP.jpg\\\\\\",null]\\""'
    の形で来たので、あきらめた。(きりがない。)

    上記の諸事情があり、
    復元処理に関しては、sessionStorageで行うように方向転換をした経緯があります。

    最終的に、2回目以降、つまり、何度でも、バリデーションエラーが立て続けに起きたケースでも
    アップロードUIの復元が可能な状態とした
*/
// アップロードUIの復元情報をsessionStorageに保存する。
// (formのonsubmitから実行される前提)
function saveUploadUIInfo(event) {
    // submitの動作を一旦、止める
    event.preventDefault();

    // 現在のアップロードUIの情報を取得する。
    let uploadUIInfo = getUploadUIInfo();

    // sessionStorageに保存する。
    sessionStorage.setItem('uploadUiRestoreInfoFileUuids', JSON.stringify(uploadUIInfo.fileUuids));
    sessionStorage.setItem('uploadUiRestoreInfoFileNames', JSON.stringify(uploadUIInfo.fileNames));

    event.target.submit();
}

// 現在のアップロードUIの情報を取得する。
function getUploadUIInfo()
{
    let fileUuids = [];
    let fileNames = [];

    $('.file-upload-wrapper').each(function() {
        const uuid = $(this).find('.file-uuid').val();
        const fileName = $(this).find('.file-name').val();

        if (uuid && fileName) {
            fileUuids.push(uuid);
            fileNames.push(fileName);
        }
    });

    let ret = {
        "fileUuids" : fileUuids,
        "fileNames" : fileNames,
    };

    return ret;
}

/**
 * 「addOrDeleteFileCallBack」によるコールバック実行の必要性があれば、コールバック実行する。
 */
function doAddOrDeleteFileCallBack(imageType) {

    /*
        アップロードのUIのサムネイル画像とは別に、画面に該当の画像をまさに表示中の状況で
        画像追加、画像削除のたびに、その画像を表示更新すべきケースもあるかもしれない

        「アップロード／削除」コンポーネントの実装は、ajax通信であるため、画面全体のリロードは行わないが、
        「アップロード／削除」コンポーネントを利用側の画面では、「画像追加」、「画像削除」の結果
        表示更新に必要な、imgタグのsrc属性値にそのまま、指定可能な形でのpath
        欲しくかつ、表示更新の処理のトリガーを発火させてほしいケースがあると予想される。

        imgタグのsrc属性値にそのまま、指定可能な形でのpathを求めるのは、
        当「アップロード／削除」コンポーネントが最も得意なので、それを当「アップロード／削除」コンポーネントの責務として
        外部より、依存性の注入をされた関数をに引数指定しコールバック実行することとした。

        その必要性が発生する画面においては、その画面が動いた場合のみ
        グローバルスコープとして見えるように( 他画面に影響が無いよう、そのようにしたうえで )
        addOrDeleteFileCallBackの名前で関数定義を行ったうえで、当コンポーネントを利用する形とする。

        当コンポーネントとしては、「 let isDefineCallBack = (typeof addOrDeleteFileCallBack === 'function');」にて、
        それがあると判定された場合は、imgタグのsrc属性値にそのまま、
        指定可能な形でのpathを引数指定しコールバック実行をする。
    */

    let isDefineCallBack = (typeof addOrDeleteFileCallBack === 'function');

    if(!isDefineCallBack) {
        return;
    }

    let filePaths = getFilePaths(imageType);

    // コールバック実行 ( 利用先での画像更新処理がなされることを期待 )
    addOrDeleteFileCallBack(filePaths);
}

/**
 * 「validateErrorRestoreCallBack」によるコールバック実行の必要性があれば、コールバック実行する。
 */
function doValidateErrorRestoreCallBack(imageType) {

    /*
        バリデーションエラー時の再表示は、submit系の処理での画面リロードでの
        表示更新となるため、
        アップロードのUIのサムネイル画像とは別に、画面に該当の画像をまさに表示中
        のものは、DB値の画像で表示更新されてしまうことになる。
        
        画像追加、画像削除のたびに、DB反映をせず、「更新する」などのボタンで
        DB反映をする実装にしているため

        画像追加、画像削除で変更していても、バリデーションエラーで、
        その分が、未だ、DB反映されていないため

        前回、DB反映されてた分でのDB値の画像で、
        アップロードのUIのサムネイル画像とは別に、画面に該当の画像をまさに表示中
        のものは、表示更新されることになる

        つまり、画像追加、画像削除して「更新する」ボタンなどを押して
        バリデーションエラーになって、画面が表示更新されると
        画像追加、画像削除の操作を行う前の状態で表示更新されてしまうことになる。

        そうでなくて、
        画像追加、画像削除の操作を行ったアップロードのUIのサムネイル画像の表示状態
        で、バリデーションエラー時も表示更新されて、
        そして、バリデーションエラーを解決したら、
        画像追加、画像削除の操作を行ったアップロードのUIのサムネイル画像の表示状態
        を、正しく、DB反映できる状況したい

        その必要性が発生する画面においては、その画面が動いた場合のみ
        グローバルスコープとして見えるように( 他画面に影響が無いよう、そのようにしたうえで )
        validateErrorRestoreCallBackの名前で関数定義を行ったうえで、当コンポーネントを利用する形とする。

        当コンポーネントとしては、「 let isDefineCallBack = (typeof validateErrorRestoreCallBack === 'function');」にて、
        それがあると判定された場合は、imgタグのsrc属性値にそのまま、
        指定可能な形でのpathを引数指定しコールバック実行をする。
    */

    let isDefineCallBack = (typeof validateErrorRestoreCallBack === 'function');

    if(!isDefineCallBack) {
        return;
    }

    let filePaths = getFilePaths(imageType);

    // コールバック実行 ( 利用先での画像更新処理がなされることを期待 )
    validateErrorRestoreCallBack(filePaths);
}

/**
 * 現在のアップロードUIの状態に基づいて、
 * imgタグのsrc属性値にそのまま、指定可能な形でのpathのリストを返す。
 */
function getFilePaths(imageType)
{
    let uploadUIInfo = getUploadUIInfo();

    let filePaths = [];

    for (let index = 0 ; index < uploadUIInfo.fileUuids.length ; ++index) {
        let currentFileUuid = uploadUIInfo.fileUuids[index];
        let currentFileName = uploadUIInfo.fileNames[index];

        let currentFilePath = `images/${imageType}/${currentFileUuid}/${currentFileName}`;
        currentFilePath = $('#file-upload-base-path').val() + '/' + currentFilePath;

        filePaths.push(currentFilePath);
    }

    return filePaths;
}

/**
 * ajax通信エラー時のメッセージ出力部分の共通処理
 */
function procShowFlashDanger(msg, xhr)
{
    let detailMsg = `: エラー詳細 : ${xhr.responseText}`;
    console.error(msg + detailMsg);
    showFlashDanger(msg);
}

$(document).ready(function() {
    let imageType = $('#file-upload-imageType').val();
    let isMulti = $('#file-upload-multiFlg').val() === 'ON';
    let isEdit = $('#file-upload-editFlg').val() === 'ON';
    let baseId = null;
    if (isEdit) {
        baseId = $('#file-upload-baseId').val();
    }

    let isRestoreMode = $('#file-upload-ui-restore-mode-flg').val() === 'ON';
    if (isRestoreMode) {
        // 「アップロードUIの復元モード」の場合

        let fileUuids = JSON.parse(sessionStorage.getItem('uploadUiRestoreInfoFileUuids') || '[]');
        let fileNames = JSON.parse(sessionStorage.getItem('uploadUiRestoreInfoFileNames') || '[]');

        for (var index = 0; index < fileUuids.length; index++) {
            const uuid = fileUuids[index];
            const fileName = fileNames[index];
            
            // ファイルが未指定のアップロードUIはスキップ
            if (!uuid || !fileName) {
                continue;
            }

            createFileUpload();

            // 現時点の最終追加分を取得
            var fileWrapper = $('#file-upload-container').children().last();

            let filePath = `images/${imageType}/${uuid}/${fileName}`;

            let param = {
                fileWrapper: fileWrapper,
                filePath: filePath,
                uuid: uuid,
                fileName: fileName,
            }
            // fileWrapperをupload完了済のUI状態にする
            changeCompleteFileWrapper(param);
        }

        // アップロードUIの「さらに、バリデーションエラー時の」復元モードであるかどうか
        let isValidateErrorModeFlg = $('#file-upload-ui-restore-for-validate-error-mode-flg').val() === 'ON';
        if(isValidateErrorModeFlg) {
            // 「validateErrorRestoreCallBack」によるコールバック実行の必要性があれば、コールバック実行する。
           doValidateErrorRestoreCallBack(imageType);
        }
    }

    /*
        この時点の「fileWrapperの数」は、復元が発生しないケースは0だが
        復元が発生するケースでは復元した数となる。
        その意味での「fileWrapperの数」を見て、
        「単一画像モードで、かつ、fileWrapperの数が1つ以上ある」
        ケースを除いて、
        最初に1つ目のファイルアップロードUIを作成する。
    */
    let initAdd = true;
    // fileWrapperの数
    let fileWrapperCount = $('.file-upload-wrapper').length;
    let isExistFileWrapper = (fileWrapperCount > 0);
    if (!isMulti && isExistFileWrapper) {
        // 単一画像モードで、かつ、fileWrapperの数が1つ以上あるケースを除く
        initAdd = false;
    }
    if (initAdd) {
        // 最初に1つ目のファイルアップロードUIを作成
        createFileUpload();
    }

    // ファイル選択時
    $(document).on('change', '.file-input', function() {

        // フラッシュメッセージを消す。
        hideFlashMessages();

        const fileInput = $(this)[0];
        const fileWrapper = $(this).closest('.file-upload-wrapper');
        const file = fileInput.files[0];

        if (!file) {
            return;
        }

        // Ajaxでファイルをアップロード
        const formData = new FormData();
        formData.append('file', file);
        formData.append('imageType', imageType);

        let baseErrorMessage = "アップロードに失敗しました。「jpg、jpeg、png、またはgif」で2MBまでお願いします。";

        /*
            「$.ajax({」のdataへの指定値について

            リクエストでファイルの中身を乗せない一般的なケースは、
            data: {
            },
            key, value方式で行うのが通常であるとのこと。

            ただし、
            リクエストでファイルの中身を乗せるときは、
            javascriptのFormDataを用いるとのこと。
            この場合は、一般的にはPOSTで行うとのこと。
            ( POST以外だと周辺のライブラリが対応してないことがある )
        */
        $.ajax({
            url: '/upload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                // スピナーを表示
                showSpinner();
            },
            success: function(response) {
                try {
                    let param = {
                        fileWrapper: fileWrapper,
                        filePath: response.filePath,
                        uuid: response.uuid,
                        fileName: file.name,
                    }
                    // fileWrapperをupload完了済のUI状態にする
                    changeCompleteFileWrapper(param);

                    if(isMulti) {
                        /*
                            isMultiの場合
                            複数画像モードの場合は、アップロードに成功時に
                            新しいUIを作成し、追加アップロードできるようにする。
                        */
                        createFileUpload();
                    }

                    // 「addOrDeleteFileCallBack」によるコールバック実行の必要性があれば、コールバック実行する。
                    doAddOrDeleteFileCallBack(imageType);
                } finally {
                    // スピナーを消す
                    hideSpinner();
                }
            },
            error: function(xhr) {
                let msg = baseErrorMessage;
                procShowFlashDanger(msg, xhr);

                // スピナーを消す
                hideSpinner();
            },
        });
    });

    // 削除ボタンを押した時
    $(document).on('click', '.delete-file', function(event) {
        // sumitを抑制(form内に配置したbuttonタグだとsubmit反応してしまうため抑制)
        stopSubmit(event);

        try {
            // フラッシュメッセージを消す。
            hideFlashMessages();

            // スピナーを表示
            showSpinner();

            const fileWrapper = $(this).closest('.file-upload-wrapper');
            fileWrapper.remove();

            if(!isMulti) {
                /*
                    isMultiでない場合
                    単一画像モードの場合は、削除で消した場合に
                    再度、アップロードできるようにUIを追加する
                */
                createFileUpload();
            }

            // 「addOrDeleteFileCallBack」によるコールバック実行の必要性があれば、コールバック実行する。
            doAddOrDeleteFileCallBack(imageType);
        } finally {
            // スピナーを消す
            hideSpinner();
        }
    });
});
