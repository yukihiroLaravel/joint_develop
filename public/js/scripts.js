// 画像選択の解除ボタンの表示・非表示を制御するスクリプト
var imageInput = document.getElementById('image');
var imageClearButton = document.getElementById('image-clear');

if (imageInput && imageClearButton) { // id="image"とid="image-clear"が存在する場合のみ処理を実行
    imageInput.addEventListener('change', function () {
        if (this.files.length > 0) {
            imageClearButton.classList.remove('d-none'); // ファイルが選択されたら解除ボタン表示
        } else {
            imageClearButton.classList.add('d-none'); // 選択がなければ解除ボタン非表示
        }
    });

    // 解除ボタンが押されたら、選択中のファイルをクリアして解除ボタンを再び非表示に戻す
    imageClearButton.addEventListener('click', function () {
        imageInput.value = '';
        this.classList.add('d-none'); // 解除ボタンを非表示にする
    });
}
