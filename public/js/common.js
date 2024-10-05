/**
 * スピナーを表示
 */
function showSpinner() {
    $('#processingSpinner').show();
}

/**
 * スピナーを消す
 */
function hideSpinner() {
    $('#processingSpinner').hide();
}

/**
 * onsubmitのキャンセル
 */
function stopSubmit(event) {
    // sumitを抑制
    event.preventDefault();
    event.stopPropagation();
}

// フラッシュメッセージを消す。
function hideFlashMessages() {
    $('.myserver-flash-marking').remove();
    $('#flashClientMessage').hide();
}

// トーストメッセージを表示する。
function showToast(message) {

    /*
        フラッシュメッセージの表示エリアが、
        画面上部であるため、スクロール位置が下のほうであるときに
        メッセージが出ていることがわかりにくいため
        トーストメッセージも併用することにした。
    */

    // トーストの要素取得
    var $toast = $('#toastContainer .toast');

    // メッセージを指定する。
    $toast.find('.toast-body').text(message);

    // 表示
    $toast.toast('show');
}

function showToast(message, alertClass) {
    // トーストの要素取得
    var $toastBody = $('#toastContainer .toast-body');

    // トーストボディのクラスをリセット(背景色をリセット)
    $toastBody.removeClass('alert-success alert-danger alert-warning alert-info');

    // トーストボディのクラスに新しいalertクラスを追加(背景色を設定)
    $toastBody.addClass('alert-' + alertClass);

    // メッセージを設定
    $toastBody.text(message);

    // トーストを表示
    $('#toastContainer .toast').toast('show');
}

/**
 * ページ内のvideoタグで再生中のものは停止する。
 */
function stopAllPlayingVideos() {
    // ページ内の全てのvideoタグを取得
    const videos = document.querySelectorAll('video');

    videos.forEach(video => {
        if (!video.paused) {
            // 再生中のvideoの場合

            // 再生を停止する
            video.pause();
            // 別ページに遷移などで該当のvideoタグがDOMから消えるまでは
            // 再生位置をキープしたいため、一旦、コメントアウト(初期の再生位置に戻したいかは仕様次第)
            //*** // 再生位置を最初に戻す
            //*** video.currentTime = 0;
        }
    });
}

/**
 *  「window.addEventListener('error', function (event) {」
 *  グローバルにcatchしてないjavascript例外を捕獲した時のeventオブジェクトより
 *  詳細なデバッグ情報のあるerrorMessageを取得する。
 */
function getErrorMessageOnGlobalError(event) {
    let errorMessage = `message : ${event.message}  source : ${event.filename}:${event.lineno}:${event.colno}`;
    if (event.error) {
        if (event.error.stack) {
            errorMessage += `stacktrace : ${event.error.stack}`;
        }
    }
    return errorMessage;
}

/*
    ファイルの種類に関する知識を当クラスに集約し、
    各種アプリ内のコードに分散させたくない。
    ファイルの種類ごとの各種ハンドリングを当クラスの責務としたい。

    ★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    注意事項
    ★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    しかし、フロントエンド間と、バックエンド間で分散してしまった。
    完全に同じ実装ではないが、関係する箇所は、
    app/Helpers/FileType.phpと同期をとったメンテナンスをすること！！
    ★★★★★★★★★★★★★★★★★★★★★★★★★★★★
*/
class FileType {

    static IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif'];
    static VIDEO_EXTENSIONS = ['mp4', 'webm', 'ogv', 'm4v'];

    constructor(argFileName) {
        this.fileName = argFileName;

        // ファイルの拡張子を取得して小文字に変換
        const extension = this.fileName.split('.').pop().toLowerCase();

        // 画像ファイルかどうか
        this.isImage = FileType.IMAGE_EXTENSIONS.includes(extension);

        // 動画ファイルかどうか
        this.isVideo = FileType.VIDEO_EXTENSIONS.includes(extension);

        // どちらにも該当しない場合
        this.isOther = !this.isImage && !this.isVideo;
    }

    /*
        アップロードに関してバリデーションチェックをする(クライアント側)
    */
    validate(
        // 動画のアップロードが可能なモードかどうか
        isEnableVideo,

        // 1ファイルあたりの最大アップロードサイズ(単位:MB)
        uploadMaxFilesize,

        // 画像の場合の仕様で決めたアップロードの最大サイズ(単位:MB)
        uploadImageMaxFilesize,

        // 今回、アップロードしようとしているファイルのサイズ(単位:バイト数)
        fileSize
    )
    {
        let allowedExtensions;
        if (isEnableVideo) {
            // 動画と画像両方の拡張子を連結してカンマ区切りにする
            allowedExtensions = [...FileType.IMAGE_EXTENSIONS, ...FileType.VIDEO_EXTENSIONS].join(', ');
        } else {
            // 画像の拡張子のみをカンマ区切りにする
            allowedExtensions = FileType.IMAGE_EXTENSIONS.join(', ');
        }

        if (this.isOther) {
            return `アップロード可能な「ファイル」は「${allowedExtensions}」です。`;
        }

        if (!isEnableVideo) {
            // 動画のアップロードが許可されていない場合

            if(this.isVideo) {
                // 動画を指定した場合

                return `アップロード可能な「ファイル」は「${allowedExtensions}」です。`;
            }
        }

        if(this.isVideo) {
            if(fileSize > (uploadMaxFilesize * 1024 * 1024) ) {
                return `アップロード可能な「動画」は${uploadMaxFilesize}MB以内です。`;
            }
        }

        if(this.isImage) {
            if(fileSize > (uploadImageMaxFilesize * 1024 * 1024) ) {
                return `アップロード可能な「画像」は${uploadImageMaxFilesize}MB以内です。`;
            }
        }

        return null;
    }

    /**
     * baseのディレクリ名を返す
     * 
     * storage/XXX/{type}/{uuid}/{fileName}
     * のパスのうち、XXXの部分に相当する
     */
    getBaseDirName()
    {
        if(this.isImage) {
            return "images";
        }
        if(this.isVideo) {
            return "videos";
        }

        throw new Exception("不正な状況");
    }
}
