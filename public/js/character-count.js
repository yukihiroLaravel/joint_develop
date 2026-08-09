document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.js-character-count').forEach(function (textarea) {

        const formGroup = textarea.closest('.form-group');
        const count = formGroup.querySelector('.js-character-count-display');
        const error = formGroup.querySelector('.js-character-count-error');
        const form = textarea.closest('form');
        const submitButton = form.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.textContent.trim();

        function checkLength() {
            const length = textarea.value.length;

            count.textContent = length;

            if (length > 140) {
                error.textContent = '投稿内容は140文字以内で入力してください。';
                error.style.display = 'block';

                submitButton.textContent = '140文字以内にしてください';
                submitButton.classList.remove('btn-primary');
                submitButton.classList.add('btn-danger');

                return false;
            }

            error.textContent = '';
            error.style.display = 'none';

            submitButton.textContent = originalButtonText;
            submitButton.classList.remove('btn-danger');
            submitButton.classList.add('btn-primary');

            return true;
        }

        textarea.addEventListener('input', checkLength);

        form.addEventListener('submit', function (event) {
            if (!checkLength()) {
                event.preventDefault();
            }
        });

    });
});