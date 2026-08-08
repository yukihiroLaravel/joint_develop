<style>
    #notificationPanel {
        width: 500px;
        max-width: calc(100vw - 2rem);
        max-height: 360px;
        overflow-y: auto;
    }

    #notificationPanel .dropdown-item {
        white-space: normal;
        overflow-wrap: anywhere;
        line-height: 1.5;
    }
</style>

<li class="nav-item position-relative">
    <button
        type="button"
        id="notificationButton"
        class="btn btn-link nav-link text-light p-2"
        aria-label="通知を開く"
        aria-expanded="false"
    >
        <i class="fas fa-bell"></i>
        <span id="notificationBadge" class="badge badge-danger" hidden>
            0
        </span>
    </button>

    <div
        id="notificationPanel"
        class="dropdown-menu dropdown-menu-right p-0"
        aria-live="polite"
    >
        <div class="dropdown-header">通知</div>
        <div id="notificationList"></div>
    </div>
</li>