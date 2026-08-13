@push('scripts')
    <script id="reaction-confetti-data" type="application/json">
        @json(['reactionType' => $reactionType])
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const reduceMotion = window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            ).matches;

            if (reduceMotion) {
                return;
            }

            const dataElement = document.getElementById(
                'reaction-confetti-data'
            );

            if (!dataElement) {
                return;
            }

            let data;

            try {
                data = JSON.parse(dataElement.textContent);
            } catch (error) {
                return;
            }

            const reactionButtons = document.querySelectorAll(
                'button[name="reaction_type"]'
            );
            let selectedButton = null;

            reactionButtons.forEach(function (button) {
                if (button.value === data.reactionType) {
                    selectedButton = button;
                }
            });

            if (!selectedButton) {
                return;
            }

            const buttonRect = selectedButton.getBoundingClientRect();
            const buttonIsVisible = buttonRect.bottom > 0 &&
                buttonRect.top < window.innerHeight;
            const originX = buttonIsVisible
                ? buttonRect.left + (buttonRect.width / 2)
                : window.innerWidth / 2;
            const originY = buttonIsVisible
                ? buttonRect.top + (buttonRect.height / 2)
                : window.innerHeight * 0.45;
            const colors = ['#5ea6ef', '#55c59c', '#ffd05b', '#f36f91'];
            const confettiLayer = document.createElement('div');

            confettiLayer.className = 'reaction-confetti-layer';
            confettiLayer.setAttribute('aria-hidden', 'true');

            for (let index = 0; index < 36; index += 1) {
                const piece = document.createElement('span');
                const endX = Math.round((Math.random() - 0.5) * 340);
                const rotation = Math.round((Math.random() - 0.5) * 1080);

                piece.className = 'reaction-confetti-piece';
                piece.style.setProperty('--confetti-origin-x', originX + 'px');
                piece.style.setProperty('--confetti-origin-y', originY + 'px');
                piece.style.setProperty('--confetti-mid-x', Math.round(endX * 0.45) + 'px');
                piece.style.setProperty('--confetti-end-x', endX + 'px');
                piece.style.setProperty('--confetti-rise', (70 + Math.round(Math.random() * 90)) + 'px');
                piece.style.setProperty('--confetti-fall', (170 + Math.round(Math.random() * 150)) + 'px');
                piece.style.setProperty('--confetti-rotation', rotation + 'deg');
                piece.style.setProperty('--confetti-mid-rotation', Math.round(rotation * 0.45) + 'deg');
                piece.style.setProperty('--confetti-width', (7 + Math.round(Math.random() * 5)) + 'px');
                piece.style.setProperty('--confetti-height', (5 + Math.round(Math.random() * 6)) + 'px');
                piece.style.setProperty('--confetti-color', colors[index % colors.length]);
                piece.style.setProperty('--confetti-radius', index % 3 === 0 ? '50%' : '2px');
                piece.style.setProperty('--confetti-duration', (1800 + Math.round(Math.random() * 900)) + 'ms');
                piece.style.setProperty('--confetti-delay', Math.round(Math.random() * 180) + 'ms');

                confettiLayer.appendChild(piece);
            }

            document.body.appendChild(confettiLayer);

            window.setTimeout(function () {
                confettiLayer.remove();
            }, 3100);
        });
    </script>
@endpush
