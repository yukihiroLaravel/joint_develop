// confirmDelete.js

document.addEventListener('DOMContentLoaded', function () {
    const deleteButton = document.querySelector('.delete-account');
    
    if (deleteButton) {
        deleteButton.addEventListener('click', function (event) {
            event.preventDefault();
            
            const userName = this.dataset.userName;
            const userEmail = this.dataset.userEmail;
            
            const confirmation = confirm(
                `以下のユーザ情報が削除されます。\n\n` +
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

