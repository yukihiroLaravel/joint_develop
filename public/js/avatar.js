/*
    アップロード／削除のコンポーネントから
    「画像関係のDBの再構成」した後のコールバックで実行される関数

    引数は、imgタグのsrc属性にそのまま指定可能なurlの配列

    その値を使ってアバター画像の表示更新をする。
*/
function reconstructionImageDBCallBack(filePaths)
{
    let imgSrcParam = '';
    if(filePaths) {
        if(filePaths.length > 0) {
            imgSrcParam = filePaths[0];
        }
    }

    $('#avatarImgSrcParam').val(imgSrcParam);

    switchImage();
}

/*
    アップロード済アバター画像表示用のimgタグと
    Gravatarの画像表示用のimgタグとで
    show()とhide()を入れ替える
*/
function switchImage()
{
    let imgSrcParam = $('#avatarImgSrcParam').val();

    if (imgSrcParam) {
        $('#imgUploadedAvatar').attr('src', imgSrcParam);
        $('#imgUploadedAvatar').show();
        $('#imgGravatar').hide();
    } else {
        $('#imgUploadedAvatar').attr('src', '');
        $('#imgUploadedAvatar').hide();
        $('#imgGravatar').show();
    }
}
/*
    初期状態のavatarImgSrcParamの値に応じて、
    アップロード済アバター画像表示用のimgタグと
    Gravatarの画像表示用のimgタグとで
    show()とhide()を入れ替える
*/
$(document).ready(function() {
    switchImage();
});
