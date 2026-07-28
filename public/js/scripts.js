document.getElementById('image').addEventListener('change', function () {
    var clearButton = document.getElementById('image-clear');
    if (this.files.length > 0) {
        clearButton.classList.remove('d-none'); // ファイルが選ばれたら表示
    } else {
        clearButton.classList.add('d-none'); // 選択が空なら非表示
    }
});

document.getElementById('image-clear').addEventListener('click', function () {
    var input = document.getElementById('image');
    input.value = '';
    this.classList.add('d-none'); // 解除したら再び非表示に戻す
});
