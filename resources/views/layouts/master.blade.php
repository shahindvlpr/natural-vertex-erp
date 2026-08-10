{{-- resources/views/layouts/master.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Natural Vertex ERP')</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    
    <style>
        /* ============================================
           ROOT VARIABLES - NO BORDER-RADIUS
        ============================================ */
        :root {
            --sidebar-width: 270px;
            --sidebar-collapsed: 72px;
            --header-height: 64px;
            --primary: #6c5ce7;
            --primary-light: #a29bfe;
            --primary-dark: #4a3db8;
            --sidebar-bg: #0b0b1a;
            --sidebar-dark: #080812;
            --sidebar-hover: #16162e;
            --sidebar-active: #1f1f42;
            --text-white: #ffffff;
            --text-light: #9898aa;
            --text-muted: #5a5a70;
            --bg-light: #f5f6fa;
            --border-color: #e8eaed;
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            --shadow-lg: 0 12px 48px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* ============================================
           RESET & BASE
        ============================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f0f2f5;
            overflow-x: hidden;
            color: #1a1a2e;
        }
        
        /* ============================================
           SIDEBAR OVERLAY (Mobile)
        ============================================ */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
        }
        
        .sidebar-overlay.show {
            display: block;
        }
        
        /* ============================================
           MAIN CONTENT
        ============================================ */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: var(--transition);
        }
        
        /* ============================================
           PAGE CONTENT
        ============================================ */
        .page-content {
            padding: 28px 32px 40px;
        }
        
        /* ============================================
           PAGE LOADER
        ============================================ */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.92);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }
        
        .page-loader.hidden {
            opacity: 0;
            pointer-events: none;
        }
        
        .page-loader .loader {
            width: 48px;
            height: 48px;
            border: 3px solid var(--border-color);
            border-top: 3px solid var(--primary);
            animation: spin 0.8s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* ============================================
           SCROLL TO TOP
        ============================================ */
        .scroll-top {
            position: fixed;
            bottom: 32px;
            right: 32px;
            width: 44px;
            height: 44px;
            background: var(--primary);
            border: none;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 999;
            box-shadow: 0 4px 16px rgba(108, 92, 231, 0.25);
        }
        
        .scroll-top.visible {
            opacity: 1;
            visibility: visible;
        }
        
        .scroll-top:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 6px 24px rgba(108, 92, 231, 0.35);
        }
        
        .scroll-top:active {
            transform: scale(0.95);
        }
        
        /* ============================================
           RESPONSIVE - MAIN CONTENT
        ============================================ */
        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
            }
            
            .page-content {
                padding: 20px 20px 32px;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
        }
        
        @media (max-width: 576px) {
            .page-content {
                padding: 16px 16px 24px;
            }
            
            .scroll-top {
                bottom: 20px;
                right: 20px;
                width: 40px;
                height: 40px;
                font-size: 16px;
            }
        }
        
        /* ============================================
           SCROLLBAR
        ============================================ */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-light);
        }
        
        /* ============================================
           SELECTION
        ============================================ */
        ::selection {
            background: var(--primary);
            color: #fff;
        }
        
        /* ============================================
           UTILITY CLASSES
        ============================================ */
        .text-primary-custom {
            color: var(--primary) !important;
        }
        
        .bg-primary-custom {
            background: var(--primary) !important;
        }
        
        .border-primary-custom {
            border-color: var(--primary) !important;
        }
        
        /* ============================================
           TRANSITION HELPER
        ============================================ */
        .fade-in {
            animation: fadeIn 0.4s ease;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* ============================================
           CARD BASE STYLES (No Border-Radius)
        ============================================ */
        .card-custom {
            background: #ffffff;
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }
        
        .card-custom:hover {
            box-shadow: var(--shadow-lg);
        }
        
        .card-custom .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 16px 20px;
            font-weight: 600;
        }
        
        .card-custom .card-body {
            padding: 20px;
        }
        
        .card-custom .card-footer {
            background: transparent;
            border-top: 1px solid var(--border-color);
            padding: 12px 20px;
        }
    </style>
    
    @stack('styles')
    
</head>
<body>
    <!-- ============================================
         PAGE LOADER
    ============================================ -->
    <div class="page-loader" id="pageLoader">
        <div class="loader"></div>
    </div>
    
    <!-- ============================================
         SIDEBAR OVERLAY (Mobile)
    ============================================ -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- ============================================
         SIDEBAR
    ============================================ -->
    @include('layouts.partials.sidebar')
    
    <!-- ============================================
         MAIN CONTENT
    ============================================ -->
    <div class="main-content">
        <!-- Header -->
        @include('layouts.partials.header')
        
        <!-- Page Content -->
        <div class="page-content">
            @yield('content')
        </div>
    </div>
    
    <!-- ============================================
         SCROLL TO TOP
    ============================================ -->
    <button class="scroll-top" id="scrollTop" aria-label="Scroll to top">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- ============================================
         SCRIPTS
    ============================================ -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            'use strict';
            
            console.log('✅ DOM Loaded');
            
            // ============================================
            // PAGE LOADER
            // ============================================
            setTimeout(function() {
                const loader = document.getElementById('pageLoader');
                if (loader) {
                    loader.classList.add('hidden');
                }
            }, 500);
            
            // ============================================
            // SIDEBAR TOGGLE (Mobile)
            // ============================================
            const toggleBtn = document.querySelector('.toggle-btn');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (toggleBtn && sidebar && overlay) {
                toggleBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                    document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
                });
                
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.style.overflow = '';
                });
                
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                        overlay.classList.remove('show');
                        document.body.style.overflow = '';
                    }
                });
            }
            
            // ============================================
            // SUB-MENU TOGGLE - FIXED
            // ============================================
            const submenuToggles = document.querySelectorAll('.nav-link.has-submenu');
            console.log('✅ Found ' + submenuToggles.length + ' submenu toggles');
            
            submenuToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    console.log('✅ Toggle clicked:', this);
                    
                    // Get the target ID from data-target attribute
                    const targetId = this.getAttribute('data-target');
                    console.log('✅ targetId:', targetId);
                    
                    // Find the submenu by ID
                    const subMenu = document.getElementById(targetId);
                    console.log('✅ subMenu found:', subMenu ? 'Yes' : 'No');
                    
                    // Find the arrow
                    const arrow = this.querySelector('.arrow');
                    
                    if (subMenu) {
                        // Close all other submenus
                        const allSubMenus = document.querySelectorAll('.sub-menu');
                        allSubMenus.forEach(function(menu) {
                            if (menu.id !== targetId) {
                                menu.classList.remove('open');
                                // Also remove open class from parent arrow
                                const parentToggle = document.querySelector('[data-target="' + menu.id + '"]');
                                if (parentToggle) {
                                    const parentArrow = parentToggle.querySelector('.arrow');
                                    if (parentArrow) {
                                        parentArrow.classList.remove('open');
                                    }
                                }
                            }
                        });
                        
                        // Toggle current submenu
                        subMenu.classList.toggle('open');
                        console.log('✅ Sub-menu toggled, open:', subMenu.classList.contains('open'));
                        
                        // Toggle arrow
                        if (arrow) {
                            arrow.classList.toggle('open');
                        }
                    } else {
                        console.log('❌ Sub-menu not found for id:', targetId);
                    }
                });
            });
            
            // ============================================
            // SCROLL TO TOP
            // ============================================
            const scrollTopBtn = document.getElementById('scrollTop');
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 200) {
                    scrollTopBtn.classList.add('visible');
                } else {
                    scrollTopBtn.classList.remove('visible');
                }
            });
            
            scrollTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
            
            // ============================================
            // WINDOW RESIZE - Fix Sidebar
            // ============================================
            window.addEventListener('resize', function() {
                if (window.innerWidth > 992) {
                    if (sidebar) {
                        sidebar.classList.remove('show');
                    }
                    if (overlay) {
                        overlay.classList.remove('show');
                    }
                    document.body.style.overflow = '';
                }
            });
            
            // ============================================
            // DATATABLES INIT (if exists)
            // ============================================
            if (typeof $.fn.DataTable !== 'undefined') {
                $('.data-table').each(function() {
                    $(this).DataTable({
                        responsive: true,
                        pageLength: 25,
                        language: {
                            search: '',
                            searchPlaceholder: 'Search...'
                        }
                    });
                });
            }
            
            // ============================================
            // SELECT2 INIT (if exists)
            // ============================================
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').each(function() {
                    $(this).select2({
                        theme: 'bootstrap-5',
                        width: '100%'
                    });
                });
            }
            
            console.log('✅ Natural Vertex ERP initialized successfully!');
        });
    </script>
    
    @stack('scripts')
</body>
</html>