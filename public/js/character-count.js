document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.js-character-count').forEach(function (textarea) {

        const formGroup = textarea.closest('.form-group');
        const count = formGroup.querySelector('.js-character-count-display');
        const error = formGroup.querySelector('.js-character-count-error');
        const form = textarea.closest('form');
        const submitButton = form.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.textContent.trim();
        const maxLength = Number(textarea.dataset.maxLength);

        function checkLength() {
            const length = textarea.value.length;

            count.textContent = length;

            if (length > maxLength) {
                if (error) {
                    error.textContent = `投稿内容は${maxLength}文字以内で入力してください。`;
                    error.style.display = 'block';
                }

                submitButton.textContent = originalButtonText;
                submitButton.classList.remove('btn-primary');
                submitButton.classList.add('btn-secondary');
                submitButton.disabled = true;

                return false;
            }

            if (error) {
                error.textContent = '';
                error.style.display = 'none';
            }

            submitButton.textContent = originalButtonText;
            submitButton.classList.remove('btn-secondary');
            submitButton.classList.add('btn-primary');
            submitButton.disabled = false;

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