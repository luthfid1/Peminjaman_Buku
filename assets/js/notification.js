// Notification System
document.addEventListener('DOMContentLoaded', function () {
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationMenu = document.getElementById('notificationMenu');

    if (notificationBtn) {
        notificationBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            notificationMenu.classList.toggle('active');
        });
    }

    // Close menu when clicking outside
    document.addEventListener('click', function (e) {
        if (notificationMenu && !notificationMenu.contains(e.target) && !notificationBtn.contains(e.target)) {
            notificationMenu.classList.remove('active');
        }
    });

    // Load notifications
    loadNotifications();
});

function closeNotificationMenu() {
    const notificationMenu = document.getElementById('notificationMenu');
    if (notificationMenu) {
        notificationMenu.classList.remove('active');
    }
}

function loadNotifications() {
    // Fetch notifications from server
    fetch('index.php?page=api&action=getNotifications')
        .then(response => response.json())
        .then(data => {
            displayNotifications(data.notifications || []);
            updateNotificationBadge(data.count || 0);
        })
        .catch(error => console.log('Error loading notifications:', error));
}

function displayNotifications(notifications) {
    const notificationList = document.getElementById('notificationList');

    if (!notificationList) return;

    if (notifications.length === 0) {
        notificationList.innerHTML = `
            <div class="notification-empty">
                <i class="bi bi-inbox"></i>
                <p>Tidak ada notifikasi</p>
            </div>
        `;
        return;
    }

    let html = '';
    notifications.forEach(notif => {
        html += `
            <div class="notification-item ${notif.read ? '' : 'unread'}">
                <div class="notification-icon ${notif.type}">
                    <i class="${notif.icon}"></i>
                </div>
                <div class="notification-content">
                    <p class="notification-title">${notif.title}</p>
                    <p class="notification-desc">${notif.message}</p>
                    <p class="notification-time">${notif.time}</p>
                </div>
            </div>
        `;
    });

    notificationList.innerHTML = html;
}

function updateNotificationBadge(count) {
    const badge = document.getElementById('notificationBadge');
    if (badge) {
        badge.textContent = count;
        if (count === 0) {
            badge.style.display = 'none';
        } else {
            badge.style.display = 'flex';
        }
    }
}

// Refresh notifications every 30 seconds
setInterval(loadNotifications, 30000);
