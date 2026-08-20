{{-- resources/views/layouts/partials/sidebar.blade.php --}}
@php
    $currentRoute = request()->route()->getName();
    
    $menuItems = [
        [
            'label' => 'Dashboard',
            'icon' => 'fa-th-large',
            'route' => 'dashboard.index',
            'active' => $currentRoute == 'dashboard.index'
        ],
        [
            'label' => 'Company Settings',
            'icon' => 'fa-building',
            'submenu' => [
                ['label' => 'Company Info', 'icon' => 'fa-info-circle', 'route' => 'company.settings'],
                ['label' => 'Logo & Signature', 'icon' => 'fa-image', 'route' => 'company.settings'],
                ['label' => 'System Settings', 'icon' => 'fa-cog', 'route' => 'company.settings'],
            ],
            'active' => $currentRoute == 'company.settings'
        ],
        [
            'label' => 'User & Permission',
            'icon' => 'fa-users-cog',
            'submenu' => [
                ['label' => 'Users', 'icon' => 'fa-users', 'route' => 'users.index'],
                ['label' => 'Roles', 'icon' => 'fa-user-tag', 'route' => 'roles.index'],
                ['label' => 'Permissions', 'icon' => 'fa-key', 'route' => 'permissions.index'],
                ['label' => 'Audit Log', 'icon' => 'fa-history', 'route' => 'audit.index'],
            ],
            'active' => in_array($currentRoute, ['users.index', 'users.create', 'users.edit', 'roles.index', 'roles.create', 'roles.edit', 'permissions.index', 'permissions.create', 'permissions.edit', 'audit.index'])
        ],
        [
            'label' => 'HR',
            'icon' => 'fa-user-friends',
            'submenu' => [
                ['label' => 'Employees', 'icon' => 'fa-user-plus', 'route' => 'hr.employees.index'],
                ['label' => 'Departments', 'icon' => 'fa-building', 'route' => 'hr.departments.index'],
                ['label' => 'Designations', 'icon' => 'fa-user-tie', 'route' => 'hr.designations.index'],
                ['label' => 'Shifts', 'icon' => 'fa-clock', 'route' => 'hr.shifts.index'],
                ['label' => 'Holidays', 'icon' => 'fa-calendar-day', 'route' => 'hr.holidays.index'],
            ],
            'active' => str_starts_with($currentRoute, 'hr.')
        ],
        [
            'label' => 'Attendance',
            'icon' => 'fa-clipboard-check',
            'submenu' => [
                ['label' => 'Daily Attendance', 'icon' => 'fa-calendar-check', 'route' => 'attendance.daily'],
                ['label' => 'Monthly Report', 'icon' => 'fa-file-alt', 'route' => 'attendance.report'],
            ],
            'active' => str_starts_with($currentRoute, 'attendance.')
        ],
        [
            'label' => 'Payroll',
            'icon' => 'fa-wallet',
            'submenu' => [
                ['label' => 'Salary Structure', 'icon' => 'fa-cog', 'route' => 'payroll.structure'],
                ['label' => 'Generate Salary', 'icon' => 'fa-plus-circle', 'route' => 'payroll.generate'],
                ['label' => 'Salary Slip', 'icon' => 'fa-file-invoice', 'route' => 'payroll.history'],
            ],
            'active' => str_starts_with($currentRoute, 'payroll.')
        ],
        [
            'label' => 'Procurement',
            'icon' => 'fa-shopping-cart',
            'submenu' => [
                ['label' => 'Purchase Request', 'icon' => 'fa-file', 'route' => 'procurement.request'],
                ['label' => 'Purchase Order', 'icon' => 'fa-file-signature', 'route' => 'procurement.order'],
                ['label' => 'Goods Receive', 'icon' => 'fa-truck', 'route' => 'procurement.goods-receive'],
                ['label' => 'Purchase Invoice', 'icon' => 'fa-file-invoice', 'route' => 'procurement.invoice'],
            ],
            'active' => str_starts_with($currentRoute, 'procurement.')
        ],
        [
            'label' => 'Supplier',
            'icon' => 'fa-truck',
            'submenu' => [
                ['label' => 'Supplier List', 'icon' => 'fa-list', 'route' => 'supplier.index'],
                ['label' => 'Purchase History', 'icon' => 'fa-history', 'route' => 'supplier.purchase-history', 'params' => ['supplier' => 1]],
                ['label' => 'Supplier Statement', 'icon' => 'fa-file-alt', 'route' => 'supplier.statement', 'params' => ['supplier' => 1]],
            ],
            'active' => str_starts_with($currentRoute, 'supplier.')
        ],
        [
            'label' => 'Warehouse',
            'icon' => 'fa-warehouse',
            'submenu' => [
                ['label' => 'Warehouses', 'icon' => 'fa-store', 'route' => 'warehouse.index'],
                ['label' => 'Racks & Shelves', 'icon' => 'fa-layer-group', 'route' => 'warehouse.racks'],
                ['label' => 'Stock Transfer', 'icon' => 'fa-exchange-alt', 'route' => 'warehouse.transfer'],
                ['label' => 'Receive Stock', 'icon' => 'fa-arrow-down', 'route' => 'warehouse.receive'],
                ['label' => 'Issue Stock', 'icon' => 'fa-arrow-up', 'route' => 'warehouse.issue'],
            ],
            'active' => str_starts_with($currentRoute, 'warehouse.')
        ],
        [
            'label' => 'Inventory',
            'icon' => 'fa-boxes',
            'submenu' => [
                ['label' => 'Categories', 'icon' => 'fa-tags', 'route' => 'inventory.categories'],
                ['label' => 'Brands', 'icon' => 'fa-tag', 'route' => 'inventory.brands'],
                ['label' => 'Products', 'icon' => 'fa-box', 'route' => 'inventory.products'],
                ['label' => 'Barcode & QR', 'icon' => 'fa-barcode', 'route' => 'inventory.barcode'],
                ['label' => 'Stock Alert', 'icon' => 'fa-chart-line', 'route' => 'inventory.stock-alert'],
            ],
            'active' => str_starts_with($currentRoute, 'inventory.')
        ],
        [
            'label' => 'Production',
            'icon' => 'fa-industry',
            'badge' => 'Manufacturing',
            'submenu' => [
                ['label' => 'Raw Material', 'icon' => 'fa-flask', 'route' => 'production.raw-material'],
                ['label' => 'BOM / Recipe', 'icon' => 'fa-list-alt', 'route' => 'production.bom'],
                ['label' => 'Production Order', 'icon' => 'fa-calendar-plus', 'route' => 'production.order'],
                ['label' => 'Machines', 'icon' => 'fa-cogs', 'route' => 'production.machines'],
                ['label' => 'Quality Check', 'icon' => 'fa-check-double', 'route' => 'production.quality'],
            ],
            'active' => str_starts_with($currentRoute, 'production.')
        ],
        [
            'label' => 'Sales',
            'icon' => 'fa-shopping-bag',
            'submenu' => [
                ['label' => 'POS', 'icon' => 'fa-cash-register', 'route' => 'sales.pos'],
                ['label' => 'Invoices', 'icon' => 'fa-file-invoice', 'route' => 'sales.invoices'],
                ['label' => 'Sales Return', 'icon' => 'fa-undo', 'route' => 'sales.return'],
                ['label' => 'Discounts', 'icon' => 'fa-percent', 'route' => 'sales.discounts'],
            ],
            'active' => str_starts_with($currentRoute, 'sales.')
        ],
        [
            'label' => 'Customer',
            'icon' => 'fa-users',
            'submenu' => [
                ['label' => 'Customer List', 'icon' => 'fa-list', 'route' => 'customer.index'],
                ['label' => 'Customer Statement', 'icon' => 'fa-file-alt', 'route' => 'customer.statement'],
                ['label' => 'Due Collection', 'icon' => 'fa-money-bill', 'route' => 'customer.due-collection'],
            ],
            'active' => str_starts_with($currentRoute, 'customer.')
        ],
        [
            'label' => 'Delivery',
            'icon' => 'fa-truck',
            'submenu' => [
                ['label' => 'Pending Delivery', 'icon' => 'fa-clock', 'route' => 'delivery.pending'],
                ['label' => 'Completed Delivery', 'icon' => 'fa-check-circle', 'route' => 'delivery.completed'],
                ['label' => 'Proof of Delivery', 'icon' => 'fa-map-marker-alt', 'route' => 'delivery.proof'],
            ],
            'active' => str_starts_with($currentRoute, 'delivery.')
        ],
        [
            'label' => 'Accounts',
            'icon' => 'fa-book',
            'submenu' => [
                ['label' => 'Chart of Accounts', 'icon' => 'fa-sitemap', 'route' => 'accounts.chart'],
                ['label' => 'Voucher', 'icon' => 'fa-file-invoice', 'route' => 'accounts.voucher'],
                ['label' => 'Trial Balance', 'icon' => 'fa-balance-scale', 'route' => 'accounts.trial-balance'],
                ['label' => 'Balance Sheet', 'icon' => 'fa-file-alt', 'route' => 'accounts.balance-sheet'],
            ],
            'active' => str_starts_with($currentRoute, 'accounts.')
        ],
        [
            'label' => 'Expense',
            'icon' => 'fa-money-bill-wave',
            'submenu' => [
                ['label' => 'Expense List', 'icon' => 'fa-file-invoice', 'route' => 'expense.index'],
                ['label' => 'Add Expense', 'icon' => 'fa-plus-circle', 'route' => 'expense.create'],
                ['label' => 'Expense Report', 'icon' => 'fa-chart-pie', 'route' => 'expense.report'],
            ],
            'active' => str_starts_with($currentRoute, 'expense.')
        ],
        [
            'label' => 'Banking',
            'icon' => 'fa-university',
            'submenu' => [
                ['label' => 'Bank Accounts', 'icon' => 'fa-credit-card', 'route' => 'banking.accounts'],
                ['label' => 'Deposit', 'icon' => 'fa-arrow-down', 'route' => 'banking.deposit'],
                ['label' => 'Withdraw', 'icon' => 'fa-arrow-up', 'route' => 'banking.withdraw'],
                ['label' => 'Transfer', 'icon' => 'fa-exchange-alt', 'route' => 'banking.transfer'],
            ],
            'active' => str_starts_with($currentRoute, 'banking.')
        ],
        [
            'label' => 'Reports',
            'icon' => 'fa-chart-bar',
            'submenu' => [
                ['label' => 'Sales Report', 'icon' => 'fa-file-alt', 'route' => 'reports.sales'],
                ['label' => 'Purchase Report', 'icon' => 'fa-file-alt', 'route' => 'reports.purchase'],
                ['label' => 'Inventory Report', 'icon' => 'fa-file-alt', 'route' => 'reports.inventory'],
                ['label' => 'Attendance Report', 'icon' => 'fa-file-alt', 'route' => 'reports.attendance'],
                ['label' => 'Profit Report', 'icon' => 'fa-file-alt', 'route' => 'reports.profit'],
            ],
            'active' => str_starts_with($currentRoute, 'reports.')
        ],
        [
            'label' => 'Analytics',
            'icon' => 'fa-chart-pie',
            'route' => 'analytics.index',
            'active' => $currentRoute == 'analytics.index'
        ],
        [
            'label' => 'Notifications',
            'icon' => 'fa-bell',
            'badge' => '5',
            'route' => 'notifications.index',
            'active' => $currentRoute == 'notifications.index'
        ],
        [
            'label' => 'System Settings',
            'icon' => 'fa-cog',
            'route' => 'system.settings',
            'active' => $currentRoute == 'system.settings'
        ],
    ];
@endphp

<nav class="sidebar" id="mainSidebar">
    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="logo-icon">
            @php
                $company = \App\Models\Company::first();
                $logo = $company && $company->logo ? asset('storage/uploads/companies/' . $company->logo) : asset('images/default-logo.png');
            @endphp
            <img src="{{ $logo }}" alt="Logo" style="width:40px; height:40px; object-fit:contain;">
        </div>
        <div class="brand-info">
            <div class="brand-text">{{ $company->name ?? 'Natural Vertex' }}</div>
            <div class="brand-sub">ERP System</div>
        </div>
    </div>

    <!-- Search -->
    <div class="sidebar-search">
        <div class="search-wrapper">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search menu..." id="sidebarSearch">
            <button class="search-clear" id="searchClear" style="display: none;">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Navigation -->
    <div class="sidebar-nav" id="sidebarNav">
        @foreach($menuItems as $item)
            @php
                $hasSubmenu = isset($item['submenu']) && count($item['submenu']) > 0;
                $isActive = isset($item['active']) ? $item['active'] : false;
                $isSubmenuActive = $hasSubmenu && collect($item['submenu'])->contains(function($sub) use ($currentRoute) {
                    return isset($sub['route']) && $sub['route'] !== '#' && $currentRoute === $sub['route'];
                });
                $isOpen = $isSubmenuActive ? 'open' : '';
            @endphp

            <div class="nav-item" data-label="{{ strtolower($item['label']) }}">
                @if($hasSubmenu)
                    <a href="javascript:void(0)" class="nav-link has-submenu {{ $isSubmenuActive || $isActive ? 'active' : '' }}" 
                       data-target="sub-{{ Str::slug($item['label']) }}">
                        <span class="nav-icon"><i class="fas {{ $item['icon'] }}"></i></span>
                        <span class="nav-label">{{ $item['label'] }}</span>
                        @if(isset($item['badge']))
                            <span class="badge badge-manufacturing">{{ $item['badge'] }}</span>
                        @endif
                        <span class="arrow {{ $isOpen ? 'open' : '' }}">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </a>
                    <div class="sub-menu {{ $isOpen }}" id="sub-{{ Str::slug($item['label']) }}">
                        @foreach($item['submenu'] as $sub)
                            @php
                                $isSubActive = isset($sub['route']) && $sub['route'] !== '#' && $currentRoute === $sub['route'];
                                $routeExists = isset($sub['route']) && $sub['route'] !== '#' && Route::has($sub['route']);
                                
                                // Build route URL with parameters if needed
                                $routeUrl = '#';
                                if ($routeExists) {
                                    try {
                                        if (isset($sub['params']) && is_array($sub['params'])) {
                                            $routeUrl = route($sub['route'], $sub['params']);
                                        } else {
                                            $routeUrl = route($sub['route']);
                                        }
                                    } catch (\Exception $e) {
                                        $routeUrl = '#';
                                    }
                                }
                            @endphp
                            <a href="{{ $routeUrl }}" 
                               class="nav-link sub-link {{ $isSubActive ? 'active' : '' }}"
                               onclick="{{ $routeUrl === '#' ? 'event.preventDefault();' : '' }}">
                                <span class="nav-icon"><i class="fas {{ $sub['icon'] }}"></i></span>
                                <span class="nav-label">{{ $sub['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @else
                    @php
                        $routeExists = isset($item['route']) && $item['route'] !== '#' && Route::has($item['route']);
                        $routeUrl = '#';
                        if ($routeExists) {
                            try {
                                $routeUrl = route($item['route']);
                            } catch (\Exception $e) {
                                $routeUrl = '#';
                            }
                        }
                    @endphp
                    <a href="{{ $routeUrl }}" 
                       class="nav-link {{ $isActive ? 'active' : '' }}"
                       onclick="{{ $routeUrl === '#' ? 'event.preventDefault();' : '' }}">
                        <span class="nav-icon"><i class="fas {{ $item['icon'] }}"></i></span>
                        <span class="nav-label">{{ $item['label'] }}</span>
                        @if(isset($item['badge']))
                            <span class="badge badge-notification">{{ $item['badge'] }}</span>
                        @endif
                    </a>
                @endif
            </div>
        @endforeach

        <!-- Logout Button -->
        <div class="nav-item nav-divider">
            <a href="#" class="nav-link logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="nav-icon"><i class="fas fa-sign-out-alt"></i></span>
                <span class="nav-label">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="version-info">
            <i class="fas fa-code-branch"></i>
            <span class="nav-label">v1.0.0</span>
        </div>
        <div class="status-dot">
            <span class="dot online"></span>
            <span class="nav-label status-text">Online</span>
        </div>
    </div>
</nav>

<style>
/* ============================================
   SIDEBAR - COMPLETE STYLES
============================================ */
:root {
    --sidebar-width: 270px;
    --sidebar-collapsed: 72px;
    --sidebar-bg: #0b0b1a;
    --sidebar-dark: #080812;
    --sidebar-hover: #16162e;
    --sidebar-active: #1f1f42;
    --primary: #6c5ce7;
    --primary-light: #a29bfe;
    --primary-dark: #4a3db8;
    --text-muted: #5a5a70;
    --text-light: #9898aa;
    --text-white: #ffffff;
    --border-color: rgba(255, 255, 255, 0.04);
    --shadow-color: rgba(108, 92, 231, 0.12);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: var(--sidebar-width);
    height: 100vh;
    background: var(--sidebar-bg);
    color: var(--text-light);
    z-index: 1050;
    display: flex;
    flex-direction: column;
    transition: var(--transition);
    overflow: hidden;
    box-shadow: 4px 0 40px rgba(0, 0, 0, 0.6);
    border-right: 1px solid var(--border-color);
}

.sidebar.collapsed {
    width: var(--sidebar-collapsed);
}

.sidebar.collapsed .brand-info,
.sidebar.collapsed .brand-sub,
.sidebar.collapsed .nav-label,
.sidebar.collapsed .badge,
.sidebar.collapsed .arrow,
.sidebar.collapsed .sidebar-search input,
.sidebar.collapsed .sub-menu .nav-label,
.sidebar.collapsed .sidebar-footer .nav-label,
.sidebar.collapsed .status-text,
.sidebar.collapsed .version-info span {
    display: none !important;
}

.sidebar.collapsed .sidebar-brand {
    justify-content: center;
    padding: 22px 0;
}

.sidebar.collapsed .logo-icon {
    margin: 0;
}

.sidebar.collapsed .sidebar-search {
    padding: 14px 0;
}

.sidebar.collapsed .sidebar-search .search-wrapper {
    justify-content: center;
}

.sidebar.collapsed .sidebar-search i {
    position: relative;
    left: 0;
}

.sidebar.collapsed .sidebar-search input {
    display: none !important;
}

.sidebar.collapsed .search-clear {
    display: none !important;
}

.sidebar.collapsed .nav-link {
    justify-content: center;
    padding: 14px 0;
    border-left: none;
}

.sidebar.collapsed .nav-link .nav-icon {
    margin: 0;
    font-size: 20px;
}

.sidebar.collapsed .nav-link.active {
    border-left: 3px solid var(--primary);
}

.sidebar.collapsed .sub-menu {
    display: none !important;
}

.sidebar.collapsed .sidebar-footer {
    flex-direction: column;
    gap: 10px;
    padding: 16px 0;
}

.sidebar.collapsed .sidebar-footer .version-info {
    flex-direction: column;
}

.sidebar.collapsed .sidebar-footer .version-info i {
    font-size: 18px;
}

.sidebar.collapsed .sidebar-footer .status-dot {
    flex-direction: column;
}

.sidebar.collapsed .sidebar-footer .status-dot .dot {
    width: 10px;
    height: 10px;
}

/* Brand */
.sidebar-brand {
    padding: 20px 24px 16px;
    display: flex;
    align-items: center;
    gap: 14px;
    border-bottom: 1px solid var(--border-color);
    flex-shrink: 0;
    min-height: 72px;
    background: var(--sidebar-dark);
    transition: var(--transition);
}

.logo-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.logo-icon img {
    width: 40px;
    height: 40px;
    object-fit: contain;
}

.brand-info {
    flex: 1;
    min-width: 0;
    transition: var(--transition);
}

.brand-text {
    color: var(--text-white);
    font-weight: 700;
    font-size: 17px;
    letter-spacing: -0.3px;
    line-height: 1.2;
}

.brand-sub {
    color: var(--text-muted);
    font-size: 9px;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    font-weight: 500;
}

/* Search */
.sidebar-search {
    padding: 14px 20px 12px;
    flex-shrink: 0;
    border-bottom: 1px solid var(--border-color);
    transition: var(--transition);
}

.search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-wrapper i {
    position: absolute;
    left: 14px;
    color: var(--text-muted);
    font-size: 13px;
    pointer-events: none;
    transition: var(--transition);
}

.search-wrapper input {
    width: 100%;
    padding: 9px 14px 9px 40px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid var(--border-color);
    border-radius: 6px;
    color: var(--text-white);
    font-size: 13px;
    transition: var(--transition);
    font-family: inherit;
    outline: none;
}

.search-wrapper input::placeholder {
    color: var(--text-muted);
    font-size: 12px;
}

.search-wrapper input:focus {
    background: rgba(255, 255, 255, 0.05);
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.06);
}

.search-wrapper input:focus + i,
.search-wrapper input:focus ~ i {
    color: var(--primary-light);
}

.search-clear {
    position: absolute;
    right: 10px;
    background: transparent;
    border: none;
    color: var(--text-muted);
    cursor: pointer;
    padding: 4px 8px;
    transition: var(--transition);
    border-radius: 4px;
}

.search-clear:hover {
    color: var(--text-white);
    background: rgba(255, 255, 255, 0.05);
}

/* Navigation */
.sidebar-nav {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 6px 12px 16px;
    transition: var(--transition);
}

.sidebar-nav::-webkit-scrollbar {
    width: 3px;
}

.sidebar-nav::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar-nav::-webkit-scrollbar-thumb {
    background: var(--primary);
    border-radius: 10px;
}

.nav-item {
    margin-bottom: 1px;
}

.nav-item.hidden {
    display: none !important;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    color: var(--text-light);
    text-decoration: none !important;
    transition: var(--transition);
    cursor: pointer;
    position: relative;
    font-size: 14px;
    font-weight: 500;
    min-height: 42px;
    border-left: 3px solid transparent;
    border-radius: 6px;
}

.nav-link:hover {
    color: var(--text-white);
    background: var(--sidebar-hover);
    text-decoration: none !important;
    border-left-color: var(--primary);
}

.nav-link.active {
    color: var(--text-white);
    background: var(--sidebar-active);
    border-left-color: var(--primary);
}

.nav-link.active::after {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    height: 100%;
    width: 3px;
    background: var(--primary);
}

.nav-icon {
    width: 22px;
    text-align: center;
    font-size: 15px;
    flex-shrink: 0;
    color: var(--text-muted);
    transition: var(--transition);
}

.nav-link:hover .nav-icon,
.nav-link.active .nav-icon {
    color: var(--primary-light);
}

.nav-label {
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: var(--transition);
}

.badge {
    font-size: 9px;
    font-weight: 600;
    padding: 2px 10px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    flex-shrink: 0;
    border-radius: 20px;
    transition: var(--transition);
}

.badge-manufacturing {
    background: #f59e0b;
    color: #0b0b1a;
}

.badge-notification {
    background: #ef4444;
    color: #fff;
    animation: pulse-badge 2s infinite;
}

@keyframes pulse-badge {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.arrow {
    margin-left: auto;
    transition: var(--transition);
    font-size: 11px;
    color: var(--text-muted);
}

.arrow.open {
    transform: rotate(90deg);
    color: var(--primary-light);
}

/* Submenu */
.sub-menu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    padding-left: 8px;
}

.sub-menu.open {
    max-height: 600px;
}

.sub-menu .nav-link {
    padding: 7px 14px 7px 32px;
    font-size: 13px;
    font-weight: 400;
    min-height: 34px;
    border-left-color: transparent;
}

.sub-menu .nav-link:hover {
    border-left-color: var(--primary);
}

.sub-menu .nav-link .nav-icon {
    font-size: 12px;
    width: 18px;
}

.nav-divider {
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid var(--border-color);
}

.logout-link {
    color: rgba(239, 68, 68, 0.5);
}

.logout-link:hover {
    color: #ef4444;
    background: rgba(239, 68, 68, 0.06);
    border-left-color: #ef4444;
}

.logout-link:hover .nav-icon {
    color: #ef4444;
}

/* Footer */
.sidebar-footer {
    padding: 12px 24px;
    border-top: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-shrink: 0;
    background: var(--sidebar-dark);
    transition: var(--transition);
}

.version-info {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 10px;
    color: var(--text-muted);
    letter-spacing: 0.5px;
    transition: var(--transition);
}

.version-info i {
    font-size: 11px;
}

.status-dot {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 10px;
    color: var(--text-muted);
    transition: var(--transition);
}

.dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    display: inline-block;
}

.dot.online {
    background: #10b981;
    animation: dot-pulse 2s infinite;
}

@keyframes dot-pulse {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.3);
    }
    50% {
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0);
    }
}

/* Responsive */
@media (max-width: 992px) {
    .sidebar {
        transform: translateX(-100%);
        width: var(--sidebar-width);
    }
    .sidebar.show {
        transform: translateX(0);
    }
    .sidebar.collapsed {
        width: var(--sidebar-width);
    }
    .sidebar.collapsed .brand-info,
    .sidebar.collapsed .brand-sub,
    .sidebar.collapsed .nav-label,
    .sidebar.collapsed .badge,
    .sidebar.collapsed .arrow,
    .sidebar.collapsed .sidebar-search input,
    .sidebar.collapsed .sub-menu .nav-label,
    .sidebar.collapsed .sidebar-footer .nav-label,
    .sidebar.collapsed .status-text,
    .sidebar.collapsed .version-info span {
        display: flex !important;
    }
    .sidebar.collapsed .sidebar-brand {
        justify-content: flex-start;
        padding: 20px 24px 16px;
    }
    .sidebar.collapsed .sidebar-search {
        padding: 14px 20px 12px;
    }
    .sidebar.collapsed .sidebar-search .search-wrapper {
        justify-content: flex-start;
    }
    .sidebar.collapsed .sidebar-search i {
        position: absolute;
        left: 14px;
    }
    .sidebar.collapsed .sidebar-search input {
        display: block !important;
    }
    .sidebar.collapsed .search-clear {
        display: block !important;
    }
    .sidebar.collapsed .nav-link {
        justify-content: flex-start;
        padding: 10px 14px;
        border-left: 3px solid transparent;
    }
    .sidebar.collapsed .nav-link .nav-icon {
        margin: 0;
        font-size: 15px;
    }
    .sidebar.collapsed .sub-menu {
        display: block !important;
    }
    .sidebar.collapsed .sidebar-footer {
        flex-direction: row;
        padding: 12px 24px;
    }
    .sidebar.collapsed .sidebar-footer .version-info {
        flex-direction: row;
    }
    .sidebar.collapsed .sidebar-footer .status-dot {
        flex-direction: row;
    }
}

@media (max-width: 576px) {
    .sidebar {
        width: 100%;
        max-width: 300px;
    }
    .sidebar-brand {
        padding: 16px 18px;
        min-height: 64px;
    }
    .logo-icon {
        width: 34px;
        height: 34px;
    }
    .logo-icon img {
        width: 34px;
        height: 34px;
    }
    .brand-text {
        font-size: 15px;
    }
    .sidebar-search {
        padding: 10px 16px;
    }
    .nav-link {
        padding: 8px 12px;
        font-size: 13px;
        min-height: 38px;
    }
    .sub-menu .nav-link {
        padding: 6px 12px 6px 28px;
        font-size: 12px;
        min-height: 34px;
    }
    .sidebar-footer {
        padding: 10px 16px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Sidebar JS loaded');
    
    
});
</script>