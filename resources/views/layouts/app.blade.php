<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Natural Vertex ERP'))</title>

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        
        <style>
            :root {
                --sidebar-width: 270px;
                --header-height: 64px;
                --primary: #6c5ce7;
                --sidebar-bg: #0b0b1a;
                --bg-light: #f5f6fa;
                --text-white: #ffffff;
            }
            
            body {
                font-family: 'Inter', sans-serif;
                background: var(--bg-light);
                overflow-x: hidden;
                color: #1a1a2e;
            }

            /* Layout Structure */
            .main-content {
                margin-left: var(--sidebar-width);
                min-height: 100vh;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .page-content {
                padding: 28px 32px 40px;
            }

            @media (max-width: 992px) {
                .main-content {
                    margin-left: 0;
                }
            }
        </style>
        @stack('styles')
    </head>
    <body>
        
        <!-- SIDEBAR -->
        @include('layouts.partials.sidebar')
        
        <!-- MAIN CONTENT -->
        <div class="main-content">
            
            <!-- HEADER -->
            @include('layouts.partials.header')
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                @yield('content')
            </div>
        </div>

        <!-- SCRIPTS -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        @stack('scripts')
    </body>
</html>