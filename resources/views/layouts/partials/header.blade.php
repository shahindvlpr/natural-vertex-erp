{{-- resources/views/layouts/partials/header.blade.php --}}
<header class="header">
    <div class="header-left">
        <button class="toggle-btn" id="sidebarToggle" aria-label="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <div class="page-info">
            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            <div class="page-breadcrumb">
                <span>Home</span>
                <span class="separator">/</span>
                <span class="current">@yield('page-title', 'Dashboard')</span>
            </div>
        </div>
    </div>
    
    <div class="header-right">
        <!-- Search -->
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search..." id="globalSearch">
            <span class="search-shortcut">Ctrl+K</span>
        </div>
        
        <!-- Notifications -->
        <div class="notification-wrapper">
            <button class="notification-btn" id="notificationToggle" type="button">
                <i class="fas fa-bell"></i>
                <span class="notification-dot">5</span>
            </button>
            <div class="notification-dropdown" id="notificationDropdown">
                <div class="notification-header">
                    <h6>Notifications</h6>
                    <a href="#" class="mark-all" id="markAllRead">Mark all read</a>
                </div>
                <div class="notification-list">
                    <div class="notification-item unread">
                        <div class="notification-icon warning">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-text">Low stock alert: Product X is running low</p>
                            <span class="notification-time">Just now</span>
                        </div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-icon success">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-text">Salary processed for 25 employees</p>
                            <span class="notification-time">15 min ago</span>
                        </div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-icon info">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-text">New invoice #INV-2024-001 created</p>
                            <span class="notification-time">1 hour ago</span>
                        </div>
                    </div>
                </div>
                <div class="notification-footer">
                    <a href="#" class="view-all">View All Notifications</a>
                </div>
            </div>
        </div>
        
        <!-- User Dropdown -->
        <div class="user-dropdown" id="userDropdown">
            <div class="user-avatar">
                {{ Auth::user() ? strtoupper(substr(Auth::user()->name, 0, 2)) : 'U' }}
                <span class="user-status online"></span>
            </div>
            <div class="user-info">
                <div class="user-name">{{ Auth::user() ? Auth::user()->name : 'Guest' }}</div>
                <div class="user-role">
                    @if(Auth::user() && Auth::user()->roles->isNotEmpty())
                        {{ Auth::user()->roles->first()->name }}
                    @else
                        No Role
                    @endif
                </div>
            </div>
            <i class="fas fa-chevron-down user-arrow"></i>
        </div>
        
        <!-- Dropdown Menu -->
        <div class="user-menu" id="userMenu">
            <div class="user-menu-header">
                <div class="user-menu-avatar">
                    {{ Auth::user() ? strtoupper(substr(Auth::user()->name, 0, 2)) : 'U' }}
                </div>
                <div class="user-menu-info">
                    <span class="user-menu-name">{{ Auth::user() ? Auth::user()->name : 'Guest' }}</span>
                    <span class="user-menu-email">{{ Auth::user() ? Auth::user()->email : '' }}</span>
                </div>
            </div>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
                <i class="fas fa-user"></i> Profile
            </a>
            <a class="dropdown-item" href="#">
                <i class="fas fa-cog"></i> Settings
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item logout-item" href="#" id="logoutBtn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</header>

<style>
/* ============================================
   HEADER - COLLAPSE SUPPORT
============================================ */
:root {
    --header-height: 64px;
    --primary: #6c5ce7;
    --primary-light: #a29bfe;
    --primary-dark: #4a3db8;
    --text-dark: #1a1a2e;
    --text-muted: #6b6b80;
    --text-light: #9898aa;
    --border-color: #e8eaed;
    --bg-light: #f5f6fa;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.header {
    position: sticky;
    top: 0;
    background: #ffffff;
    padding: 0 28px;
    height: var(--header-height);
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid var(--border-color);
    z-index: 1040;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}

/* ============================================
   HEADER LEFT
============================================ */
.header-left {
    display: flex;
    align-items: center;
    gap: 18px;
}

.toggle-btn {
    background: none;
    border: none;
    font-size: 20px;
    color: var(--text-muted);
    cursor: pointer;
    padding: 6px 10px;
    transition: var(--transition);
    display: block !important;
}

.toggle-btn:hover {
    background: var(--bg-light);
    color: var(--primary);
}

.toggle-btn:active {
    transform: scale(0.95);
}

.page-info {
    display: flex;
    flex-direction: column;
}

.page-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
    line-height: 1.2;
    letter-spacing: -0.3px;
}

.page-breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: var(--text-light);
}

.page-breadcrumb .separator {
    color: var(--border-color);
}

.page-breadcrumb .current {
    color: var(--primary);
    font-weight: 500;
}

/* ============================================
   HEADER RIGHT
============================================ */
.header-right {
    display: flex;
    align-items: center;
    gap: 14px;
    position: relative;
}

/* ============================================
   SEARCH BOX
============================================ */
.search-box {
    display: flex;
    align-items: center;
    background: var(--bg-light);
    border: 1.5px solid var(--border-color);
    padding: 0 6px 0 14px;
    transition: var(--transition);
    min-width: 220px;
}

.search-box:focus-within {
    background: #ffffff;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.06);
}

.search-box i {
    color: var(--text-light);
    font-size: 15px;
    flex-shrink: 0;
    transition: var(--transition);
}

.search-box:focus-within i {
    color: var(--primary);
}

.search-box input {
    border: none;
    background: transparent;
    padding: 8px 12px;
    font-size: 13.5px;
    color: var(--text-dark);
    width: 160px;
    font-family: inherit;
    outline: none;
}

.search-box input::placeholder {
    color: var(--text-light);
    font-size: 13px;
}

.search-shortcut {
    font-size: 11px;
    color: var(--text-light);
    background: var(--border-color);
    padding: 2px 10px;
    font-family: inherit;
    font-weight: 600;
    flex-shrink: 0;
    letter-spacing: 0.3px;
}

/* ============================================
   NOTIFICATIONS
============================================ */
.notification-wrapper {
    position: relative;
}

.notification-btn {
    background: none;
    border: none;
    padding: 8px 10px;
    cursor: pointer;
    position: relative;
    color: var(--text-muted);
    transition: var(--transition);
}

.notification-btn:hover {
    background: var(--bg-light);
    color: var(--primary);
}

.notification-btn i {
    font-size: 20px;
}

.notification-dot {
    position: absolute;
    top: 4px;
    right: 4px;
    background: #ef4444;
    color: #fff;
    font-size: 9px;
    font-weight: 700;
    padding: 1px 5px;
    min-width: 18px;
    text-align: center;
    line-height: 16px;
    border: 2px solid #fff;
}

.notification-dropdown {
    position: absolute;
    top: calc(100% + 12px);
    right: -10px;
    width: 360px;
    background: #ffffff;
    border: 1px solid var(--border-color);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.1);
    display: none;
    z-index: 1050;
    overflow: hidden;
}

.notification-dropdown.active {
    display: block;
    animation: slideDown 0.25s ease;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}

.notification-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border-color);
}

.notification-header h6 {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-dark);
    margin: 0;
}

.notification-header .mark-all {
    font-size: 12px;
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
}

.notification-header .mark-all:hover {
    text-decoration: underline;
}

.notification-list {
    max-height: 340px;
    overflow-y: auto;
}

.notification-list::-webkit-scrollbar {
    width: 4px;
}

.notification-list::-webkit-scrollbar-thumb {
    background: var(--border-color);
}

.notification-item {
    display: flex;
    gap: 12px;
    padding: 12px 20px;
    border-bottom: 1px solid var(--border-color);
    transition: var(--transition);
    cursor: pointer;
}

.notification-item:hover {
    background: var(--bg-light);
}

.notification-item.unread {
    background: #f8f7ff;
}

.notification-item.unread .notification-text {
    font-weight: 600;
}

.notification-icon {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #fff;
}

.notification-icon.warning { background: #f59e0b; }
.notification-icon.success { background: #10b981; }
.notification-icon.info { background: #3b82f6; }
.notification-icon.danger { background: #ef4444; }

.notification-icon i {
    font-size: 14px;
}

.notification-content {
    flex: 1;
    min-width: 0;
}

.notification-text {
    font-size: 13px;
    color: var(--text-dark);
    margin: 0 0 4px 0;
    line-height: 1.4;
}

.notification-time {
    font-size: 11px;
    color: var(--text-light);
}

.notification-footer {
    padding: 12px 20px;
    text-align: center;
    border-top: 1px solid var(--border-color);
}

.notification-footer .view-all {
    font-size: 13px;
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
}

.notification-footer .view-all:hover {
    text-decoration: underline;
}

/* ============================================
   USER DROPDOWN
============================================ */
.user-dropdown {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    padding: 4px 10px 4px 4px;
    transition: var(--transition);
    border: 1.5px solid transparent;
}

.user-dropdown:hover {
    border-color: var(--border-color);
    background: var(--bg-light);
}

.user-dropdown.active {
    border-color: var(--primary);
    background: #f8f7ff;
}

.user-avatar {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: 14px;
    position: relative;
    flex-shrink: 0;
}

.user-status {
    position: absolute;
    bottom: -1px;
    right: -1px;
    width: 10px;
    height: 10px;
    border: 2px solid #fff;
}

.user-status.online { background: #10b981; }
.user-status.away { background: #f59e0b; }
.user-status.busy { background: #ef4444; }
.user-status.offline { background: var(--text-light); }

.user-info {
    line-height: 1.2;
    min-width: 0;
}

.user-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-dark);
}

.user-role {
    font-size: 11px;
    color: var(--text-light);
}

.user-arrow {
    font-size: 11px;
    color: var(--text-light);
    transition: var(--transition);
}

.user-dropdown.active .user-arrow {
    transform: rotate(180deg);
}

/* ============================================
   USER MENU
============================================ */
.user-menu {
    position: absolute;
    top: calc(100% + 12px);
    right: 0;
    width: 260px;
    background: #ffffff;
    border: 1px solid var(--border-color);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.1);
    display: none;
    z-index: 1050;
    overflow: hidden;
}

.user-menu.active {
    display: block;
    animation: slideDown 0.25s ease;
}

.user-menu-header {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 20px 14px;
    border-bottom: 1px solid var(--border-color);
}

.user-menu-avatar {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: 16px;
    flex-shrink: 0;
}

.user-menu-info {
    flex: 1;
    min-width: 0;
}

.user-menu-name {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-dark);
}

.user-menu-email {
    display: block;
    font-size: 12px;
    color: var(--text-light);
    word-break: break-all;
}

.user-menu .dropdown-item {
    padding: 10px 20px;
    font-size: 13px;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 12px;
    transition: var(--transition);
    text-decoration: none;
    cursor: pointer;
}

.user-menu .dropdown-item:hover {
    background: var(--bg-light);
    color: var(--primary);
}

.user-menu .dropdown-item i {
    width: 18px;
    color: var(--text-light);
    font-size: 15px;
    text-align: center;
}

.user-menu .dropdown-item:hover i {
    color: var(--primary);
}

.user-menu .logout-item {
    color: #ef4444;
}

.user-menu .logout-item i {
    color: #ef4444;
}

.user-menu .logout-item:hover {
    background: #fef2f2;
    color: #dc2626;
}

.user-menu .logout-item:hover i {
    color: #dc2626;
}

.dropdown-divider {
    height: 1px;
    background: var(--border-color);
    margin: 4px 0;
}

/* ============================================
   RESPONSIVE
============================================ */
@media (max-width: 992px) {
    .header {
        padding: 0 16px;
        height: 58px;
    }

    .search-box {
        min-width: 150px;
    }

    .search-box input {
        width: 80px;
    }

    .search-shortcut {
        display: none;
    }

    .user-info {
        display: none !important;
    }

    .user-dropdown {
        padding: 4px;
    }

    .notification-dropdown {
        width: 320px;
        right: -60px;
    }

    .user-menu {
        right: -40px;
    }
}

@media (max-width: 576px) {
    .header {
        padding: 0 12px;
        height: 52px;
    }

    .page-title {
        font-size: 15px;
    }

    .page-breadcrumb {
        display: none;
    }

    .search-box {
        display: none !important;
    }

    .notification-dropdown {
        width: 290px;
        right: -80px;
        top: calc(100% + 8px);
    }

    .user-menu {
        right: -60px;
        width: 230px;
        top: calc(100% + 8px);
    }

    .user-avatar {
        width: 30px;
        height: 30px;
        font-size: 12px;
    }

    .notification-btn i {
        font-size: 18px;
    }

    .notification-dot {
        font-size: 8px;
        min-width: 16px;
        line-height: 14px;
        top: 3px;
        right: 3px;
    }

    .notification-item {
        padding: 10px 16px;
    }
}

@media (max-width: 380px) {
    .notification-dropdown {
        width: 270px;
        right: -90px;
    }

    .user-menu {
        width: 210px;
        right: -70px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // ============================================
    // SIDEBAR TOGGLE - COLLAPSE/EXPAND
    // ============================================
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('mainSidebar');
    const overlay = document.getElementById('sidebarOverlay');

    if (toggleBtn && sidebar) {
        // Check saved state from localStorage
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed && window.innerWidth > 992) {
            sidebar.classList.add('collapsed');
        }

        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // For desktop: toggle collapse/expand
            if (window.innerWidth > 992) {
                sidebar.classList.toggle('collapsed');
                const collapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', collapsed);
                
                // Update main content margin
                const mainContent = document.querySelector('.main-content');
                if (mainContent) {
                    if (collapsed) {
                        mainContent.style.marginLeft = '72px';
                    } else {
                        mainContent.style.marginLeft = '270px';
                    }
                }
            } else {
                // For mobile: toggle show/hide
                sidebar.classList.toggle('show');
                if (overlay) {
                    overlay.classList.toggle('show');
                }
                document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
            }
        });
    }

    // Close sidebar on overlay click (mobile)
    if (overlay) {
        overlay.addEventListener('click', function() {
            if (sidebar) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
    }

    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (sidebar && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                if (overlay) overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        const mainContent = document.querySelector('.main-content');
        if (window.innerWidth > 992) {
            if (sidebar) {
                sidebar.classList.remove('show');
                if (overlay) overlay.classList.remove('show');
                document.body.style.overflow = '';
                
                // Restore collapsed state on desktop
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                    if (mainContent) {
                        mainContent.style.marginLeft = '72px';
                    }
                } else {
                    sidebar.classList.remove('collapsed');
                    if (mainContent) {
                        mainContent.style.marginLeft = '270px';
                    }
                }
            }
        } else {
            // Mobile: remove collapsed state
            if (sidebar) {
                sidebar.classList.remove('collapsed');
                if (mainContent) {
                    mainContent.style.marginLeft = '0';
                }
            }
        }
    });

    // ============================================
    // SEARCH SHORTCUT - Ctrl+K
    // ============================================
    const searchInput = document.getElementById('globalSearch');
    
    if (searchInput) {
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
            }
            
            if (e.key === 'Escape' && document.activeElement === searchInput) {
                searchInput.blur();
            }
        });
    }

    // ============================================
    // NOTIFICATION TOGGLE
    // ============================================
    const notificationBtn = document.getElementById('notificationToggle');
    const notificationDropdown = document.getElementById('notificationDropdown');

    if (notificationBtn && notificationDropdown) {
        notificationBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            notificationDropdown.classList.toggle('active');
            
            const userMenu = document.getElementById('userMenu');
            const userDropdown = document.getElementById('userDropdown');
            if (userMenu) userMenu.classList.remove('active');
            if (userDropdown) userDropdown.classList.remove('active');
        });

        document.addEventListener('click', function(e) {
            const wrapper = document.querySelector('.notification-wrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                if (notificationDropdown) {
                    notificationDropdown.classList.remove('active');
                }
            }
        });
    }

    // ============================================
    // USER DROPDOWN TOGGLE
    // ============================================
    const userDropdown = document.getElementById('userDropdown');
    const userMenu = document.getElementById('userMenu');

    if (userDropdown && userMenu) {
        userDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            userMenu.classList.toggle('active');
            userDropdown.classList.toggle('active');
            
            if (notificationDropdown) {
                notificationDropdown.classList.remove('active');
            }
        });

        document.addEventListener('click', function(e) {
            const wrapper = document.querySelector('.user-dropdown');
            if (wrapper && !wrapper.contains(e.target)) {
                if (userMenu) userMenu.classList.remove('active');
                if (userDropdown) userDropdown.classList.remove('active');
            }
        });
    }

    // ============================================
    // LOGOUT BUTTON
    // ============================================
    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('logout-form').submit();
        });
    }

    // ============================================
    // MARK ALL NOTIFICATIONS READ
    // ============================================
    const markAllBtn = document.getElementById('markAllRead');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.notification-item.unread').forEach(function(item) {
                item.classList.remove('unread');
            });
            const dot = document.querySelector('.notification-dot');
            if (dot) {
                dot.textContent = '0';
                dot.style.display = 'none';
            }
        });
    }

    // ============================================
    // NOTIFICATION ITEM CLICK
    // ============================================
    document.querySelectorAll('.notification-item').forEach(function(item) {
        item.addEventListener('click', function() {
            this.classList.remove('unread');
            const unreadCount = document.querySelectorAll('.notification-item.unread').length;
            const dot = document.querySelector('.notification-dot');
            if (dot) {
                if (unreadCount > 0) {
                    dot.textContent = unreadCount;
                    dot.style.display = 'block';
                } else {
                    dot.textContent = '0';
                    dot.style.display = 'none';
                }
            }
        });
    });

    // ============================================
    // CLOSE DROPDOWNS ON ESCAPE
    // ============================================
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (notificationDropdown && notificationDropdown.classList.contains('active')) {
                notificationDropdown.classList.remove('active');
            }
            if (userMenu && userMenu.classList.contains('active')) {
                userMenu.classList.remove('active');
                if (userDropdown) userDropdown.classList.remove('active');
            }
        }
    });

    console.log('✅ Header initialized successfully!');
});
</script>