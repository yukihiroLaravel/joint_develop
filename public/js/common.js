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

// クライアントのフラッシュメッセージを非表示にする。
function hideFlashClientMessage() {
    $('#flashClientMessage').hide();
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