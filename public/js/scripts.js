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

// ページトップへ戻るボタン
var scrollToTopButton = document.querySelector('.js-scroll-to-top');
if (scrollToTopButton) {
    window.addEventListener('scroll', function () {
        if (window.scrollY > 300) { // スクロール位置が300pxを超えたら表示
            scrollToTopButton.classList.add('is-visible');
        } else {
            scrollToTopButton.classList.remove('is-visible');
        }
    });

    scrollToTopButton.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' }); // スムーズにトップへスクロール
    });
}

// リアクションを押した時に同じ位置に移動する
// 1.リアクションフォーム送信時に位置を保存
document.querySelectorAll('.js-reaction-form').forEach(function (form) {
    form.addEventListener('submit', function () {
        sessionStorage.setItem('reactionScrollPosition', window.scrollY);
    });
});

// 2.ページ読み込み時に位置を復元
var savedScrollPosition = sessionStorage.getItem('reactionScrollPosition');
if (savedScrollPosition) {
    window.scrollTo({ top: parseInt(savedScrollPosition, 10), behavior: 'auto' });
    sessionStorage.removeItem('reactionScrollPosition');
}
