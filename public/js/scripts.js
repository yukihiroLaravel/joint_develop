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

// design-update: 投稿フォーム・編集画面で共通の文字数カウンター
// textareaに data-char-count-target="カウンター要素のid"、 data-char-count-max="上限文字数" を付けると動作。
// 上限を超えても入力は可能。超えた場合はカウンターの色をdanger色にする
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-char-count-target]').forEach(setupCharCounter);
});

function setupCharCounter(textarea) {
    var counter = document.getElementById(textarea.getAttribute('data-char-count-target'));
    if (!counter) {
        return;
    }
    // data-char-count-max未指定、または数値以外の場合は上限なし扱い
    var max = Number(textarea.getAttribute('data-char-count-max')) || Infinity;

    var updateCount = function () {
        var length = textarea.value.length;
        counter.textContent = length;
        if (counter.parentElement) {
            counter.parentElement.classList.toggle('is-over-limit', length > max);
        }
    };
    textarea.addEventListener('input', updateCount);
    updateCount();
}
