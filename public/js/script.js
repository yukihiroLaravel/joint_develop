// design-update: 投稿フォーム・編集画面で共通の文字数カウンター。
// textareaに data-char-count-target="カウンター要素のid" を付けるだけで動作する
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-char-count-target]').forEach(function (textarea) {
        var counter = document.getElementById(textarea.getAttribute('data-char-count-target'));
        if (!counter) {
            return;
        }
        var updateCount = function () {
            counter.textContent = textarea.value.length;
        };
        textarea.addEventListener('input', updateCount);
        updateCount();
    });
});
