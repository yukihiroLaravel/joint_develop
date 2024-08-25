// confirmDelete.js

document.addEventListener('DOMContentLoaded', function () {
    const deleteButton = document.querySelector('.btn-danger');
    
    if (deleteButton) {
        deleteButton.addEventListener('click', function (event) {
            event.preventDefault();
            
            const userName = this.dataset.userName;
            const userEmail = this.dataset.userEmail;
            
            const confirmation = confirm(
                `以下のユーザ情報が削除され、過去に投稿したTopicはそのまま残ります。\n\n` +
                `ユーザ名：${userName}\n` +
                `メールアドレス：${userEmail}\n\n` +
                `本当に退会してもよろしいでしょうか？`
            );

            if (confirmation) {
                this.closest('form').submit();
            }
        });
    }
});
