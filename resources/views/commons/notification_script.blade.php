@auth
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const button = document.getElementById('notificationButton');
            const panel = document.getElementById('notificationPanel');
            const badge = document.getElementById('notificationBadge');
            const list = document.getElementById('notificationList');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            function updateBadge(count) {
                badge.textContent = count;
                badge.hidden = count === 0;
            }

            function renderNotifications(notifications) {
                list.innerHTML = '';

                if (notifications.length === 0) {
                    const empty = document.createElement('p');
                    empty.className = 'dropdown-item-text text-muted mb-0';
                    empty.textContent = '通知はありません。';
                    list.appendChild(empty);
                    return;
                }

                notifications.forEach(function (notification) {
                    const link = document.createElement('a');

                    link.href = notification.url;
                    link.className = 'dropdown-item border-top';
                    link.textContent =
                        notification.reacted_by_name +
                        'さんが「' +
                        notification.reaction_label +
                        '」でリアクションしました。';

                    if (! notification.read_at) {
                        link.classList.add('font-weight-bold');
                    }

                    link.addEventListener('click', function (event) {
                        if (notification.read_at) {
                            return;
                        }

                        event.preventDefault();

                        fetch('/notifications/' + notification.id + '/read', {
                            method: 'PATCH',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(function (response) {
                            if (! response.ok) {
                                throw new Error('既読化に失敗しました。');
                            }

                            return response.json();
                        })
                        .then(function (data) {
                            updateBadge(data.unread_count);
                            window.location.href = notification.url;
                        })
                        .catch(function () {
                            window.location.href = notification.url;
                        });
                    });

                    list.appendChild(link);
                });
            }

            function loadNotifications() {
                return fetch('/notifications', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(function (response) {
                    if (! response.ok) {
                        throw new Error('通知の取得に失敗しました。');
                    }

                    return response.json();
                })
                .then(function (data) {
                    updateBadge(data.unread_count);
                    renderNotifications(data.notifications);
                });
            }

            button.addEventListener('click', function () {
                const isOpen = panel.classList.toggle('show');

                button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

                if (isOpen) {
                    loadNotifications().catch(function () {
                        list.textContent = '通知を取得できませんでした。';
                    });
                }
            });

            loadNotifications().catch(function () {
                // 初回取得失敗時は、ページ本体の表示を妨げない
            });
        });
    </script>
@endauth