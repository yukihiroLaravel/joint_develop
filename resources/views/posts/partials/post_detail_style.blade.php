<style>
    .post-detail-logo {
        width: 100%;
        max-width: 480px;
        height: auto;
    }

    .post-detail-main-card {
        padding-top: 5px;
        overflow: hidden;
        background: linear-gradient(90deg, #5ea6ef 0%, #55c59c 35%, #ffd05b 65%, #f36f91 100%);
    }

    .post-detail-main-card-body {
        background-color: #fffdf8;
    }

    .post-detail-main-label,
    .post-detail-encouragement-label {
        color: #76656b;
        background-color: #ffe4ec;
    }

    .post-detail-main-content {
        color: #343a40;
        font-size: 1.25rem;
        line-height: 1.8;
    }

    .post-detail-reaction-panel {
        background:
            linear-gradient(#f8fcfb, #f8fcfb) padding-box,
            linear-gradient(90deg, #5ea6ef, #55c59c) border-box;
        border: 1px solid transparent;
        border-top-width: 5px;
    }

    .post-detail-reaction-heading {
        color: #557a6b;
    }

    .post-detail-reaction-total {
        font-size: 1.5em;
    }

    .post-detail-encouragement-panel {
        background-color: #fff8fa;
        border: 1px solid #f5d5df;
    }

    .post-detail-positive-panel {
        background:
            linear-gradient(#fffdf8, #fffdf8) padding-box,
            linear-gradient(90deg, #ffd05b, #f36f91) border-box;
        border: 1px solid transparent;
        border-top-width: 5px;
    }

    .post-detail-positive-heading {
        color: #6b5e49;
    }

    .post-detail-positive-card {
        border-color: #f3e4c3 !important;
    }

    .reaction-confetti-layer {
        position: fixed;
        inset: 0;
        z-index: 1080;
        overflow: hidden;
        pointer-events: none;
    }

    .reaction-confetti-piece {
        position: fixed;
        top: var(--confetti-origin-y);
        left: var(--confetti-origin-x);
        width: var(--confetti-width);
        height: var(--confetti-height);
        background-color: var(--confetti-color);
        border-radius: var(--confetti-radius);
        opacity: 0;
        animation: reaction-confetti-burst var(--confetti-duration)
            cubic-bezier(0.18, 0.7, 0.25, 1) var(--confetti-delay) forwards;
    }

    @keyframes reaction-confetti-burst {
        0% {
            opacity: 0;
            transform: translate(-50%, -50%) rotate(0deg) scale(0.6);
        }

        10% {
            opacity: 1;
        }

        40% {
            opacity: 1;
            transform:
                translate(
                    calc(-50% + var(--confetti-mid-x)),
                    calc(-50% - var(--confetti-rise))
                )
                rotate(var(--confetti-mid-rotation))
                scale(1);
        }

        100% {
            opacity: 0;
            transform:
                translate(
                    calc(-50% + var(--confetti-end-x)),
                    calc(-50% + var(--confetti-fall))
                )
                rotate(var(--confetti-rotation))
                scale(0.85);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .reaction-confetti-piece {
            display: none;
            animation: none;
        }
    }
</style>
