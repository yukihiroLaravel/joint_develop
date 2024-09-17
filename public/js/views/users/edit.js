/**
 * トグル結果に関する調整処理
 */
function adjustToggleUi(divAvatar, avatarToggleLink)
{
    // リンクのテキストを表示状態に応じて変更
    if (divAvatar.is(':visible')) {
        avatarToggleLink.text('アバター画像の表示／追加／削除をしない');
        $('#toggleOnOff').val('ON');
    } else {
        avatarToggleLink.text('アバター画像の表示／追加／削除をする');
        $('#toggleOnOff').val('OFF');
    }
}
/**
 * resources/views/users/edit.blade.php
 * 「ユーザ編集」画面専用のjavascript定義
 */
$('#avatarToggleLink').on('click', function(event) {
    // リンクのデフォルトの動作を無効化
    event.preventDefault();

    var divAvatar = $('#divAvatar');
    var avatarToggleLink = $('#avatarToggleLink');

    // divAvatarの表示/非表示をトグル
    divAvatar.toggle();

    // トグル結果に関する調整処理
    adjustToggleUi(divAvatar, avatarToggleLink);
});
$(document).ready(function() {
    var divAvatar = $('#divAvatar');
    var avatarToggleLink = $('#avatarToggleLink');

    if($('#toggleOnOff').val() === 'ON') {
        divAvatar.toggle();
    }

    // トグル結果に関する調整処理
    adjustToggleUi(divAvatar, avatarToggleLink);
});
