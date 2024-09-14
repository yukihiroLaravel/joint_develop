/**
    クライアントサイドでflashメッセージを表示する関数定義
    ( Laravelフラッシュ使ってないけど、サーバーサイドのそれと同じ見た目で表示という意味 )

    複数出力対応はしてません。表示中に再表示したら前の分を置き換え表示します。
    
    使用例)
    showFlashSuccess('メッセージ');
    showFlashDanger('メッセージ');
    showFlashWarning('メッセージ');
    showFlashInfo('メッセージ');
*/
function showFlashCommon(message, alertClass) {
    // 「'alert-success alert-danger alert-warning alert-info'」のclass指定があれば消す
    $('#flashClientMessage').removeClass('alert-success alert-danger alert-warning alert-info');
    // 「'alert-' + alertClass」のclass指定を追加
    $('#flashClientMessage').addClass('alert-' + alertClass);

    // メッセージの指定
    $('#flashClientMessageContent').html(message);

    // フラッシュメッセージ表示
    $('#flashClientMessage').show();
}
/**
    「success」にてCientからメッセージの表示をする
*/
function showFlashSuccess(message)
{
    showFlashCommon(message, 'success');
}
/**
    「danger」にてCientからメッセージの表示をする
*/
function showFlashDanger(message)
{
    showFlashCommon(message, 'danger');
}
/**
    「warning」にてCientからメッセージの表示をする
*/
function showFlashWarning(message)
{
    showFlashCommon(message, 'warning');
}
/**
    「info」にてCientからメッセージの表示をする
*/
function showFlashInfo(message)
{
    showFlashCommon(message, 'info');
}
