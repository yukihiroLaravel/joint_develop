document.addEventListener('DOMContentLoaded', function () {
    var token = document.querySelector('meta[name="csrf-token"]').content;

    document.querySelectorAll('.like-button').forEach(function (button) {
        button.addEventListener('click', function () {
            var isLiked = button.dataset.liked === '1';
            var url = isLiked ? button.dataset.unlikeUrl : button.dataset.likeUrl;

            button.disabled = true; // 通信中はボタンを押せないようにする

            fetch(url, {
                method: isLiked ? 'DELETE' : 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('HTTP ' + response.status);
                    }
                    return response.json();
                })
                .then(function (data) {
                    var icon = button.querySelector('.like-icon');
                    button.dataset.liked = data.liked ? '1' : '0';
                    button.classList.toggle('text-danger', data.liked);
                    button.classList.toggle('text-muted', !data.liked);
                    icon.innerHTML = '<i class="' + (data.liked ? 'fas' : 'far') + ' fa-heart"></i>';
                    document.querySelector('.like-count[data-post-id="' + button.dataset.postId + '"]').textContent = data.count;
                })
                .catch(function () {
                    alert('通信に失敗しました。もう一度お試しください。');
                })
                .finally(function () {
                    button.disabled = false; // 成功でも失敗でも、ボタンを押せる状態に戻す
                });
        });
    });
});
