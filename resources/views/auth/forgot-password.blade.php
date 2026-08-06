{{-- resources/views/auth/forgot-password.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password - Natural Vertex ERP</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        /* ============================================
           ROOT VARIABLES
        ============================================ */
        :root {
            --primary: #6c5ce7;
            --primary-dark: #4a3db8;
            --primary-light: #a29bfe;
            --secondary: #fd79a8;
            --accent: #00cec9;
            --dark: #0a0a1a;
            --dark-card: rgba(16, 16, 36, 0.92);
            --text-white: #ffffff;
            --text-light: #b0b0c8;
            --text-muted: #6b6b80;
            --border-color: rgba(255, 255, 255, 0.08);
            --shadow: 0 8px 40px rgba(0, 0, 0, 0.4);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ============================================
           BODY
        ============================================ */
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--dark);
            position: relative;
            overflow: hidden;
        }

        /* Animated Gradient Background */
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(ellipse at 20% 30%, rgba(108, 92, 231, 0.25) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 70%, rgba(253, 121, 168, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(0, 206, 201, 0.08) 0%, transparent 60%);
            animation: gradientMove 20s ease-in-out infinite alternate;
            z-index: 0;
        }

        @keyframes gradientMove {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(5deg) scale(1.05); }
            100% { transform: rotate(-5deg) scale(0.95); }
        }

        /* Grid Pattern Overlay */
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: 0;
            pointer-events: none;
        }

        /* Floating Particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(108, 92, 231, 0.3);
            animation: floatParticle linear infinite;
        }

        .particle:nth-child(odd) {
            background: rgba(253, 121, 168, 0.2);
        }

        @keyframes floatParticle {
            0% {
                transform: translateY(100vh) translateX(0) scale(0);
                opacity: 0;
            }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% {
                transform: translateY(-10vh) translateX(50px) scale(1);
                opacity: 0;
            }
        }

        /* ============================================
           FORGOT PASSWORD WRAPPER
        ============================================ */
        .forgot-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 460px;
            padding: 20px;
        }

        .forgot-card {
            background: var(--dark-card);
            backdrop-filter: blur(24px);
            padding: 48px 44px 40px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow);
            animation: slideUp 0.7s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        /* Glow Line at Top */
        .forgot-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary), var(--secondary), transparent);
            animation: glowLine 3s ease-in-out infinite;
        }

        @keyframes glowLine {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ============================================
           HEADER
        ============================================ */
        .forgot-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-wrapper {
            width: 72px;
            height: 72px;
            margin: 0 auto 16px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 32px rgba(108, 92, 231, 0.3);
            transition: var(--transition);
        }

        .logo-wrapper:hover {
            transform: scale(1.04);
            box-shadow: 0 12px 48px rgba(108, 92, 231, 0.4);
        }

        .logo-wrapper i {
            font-size: 28px;
            color: #fff;
        }

        .forgot-header h2 {
            color: var(--text-white);
            font-weight: 800;
            font-size: 24px;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }

        .forgot-header .subtitle {
            color: var(--text-light);
            font-size: 14px;
            font-weight: 400;
            line-height: 1.6;
        }

        .forgot-header .subtitle span {
            color: var(--primary-light);
            font-weight: 600;
        }

        /* ============================================
           ALERTS
        ============================================ */
        .alert-custom {
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid transparent;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: alertSlide 0.4s ease;
        }

        @keyframes alertSlide {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-custom i {
            font-size: 16px;
            flex-shrink: 0;
        }

        .alert-custom.alert-success {
            background: rgba(16, 185, 129, 0.12);
            border-color: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
        }

        .alert-custom.alert-danger {
            background: rgba(239, 68, 68, 0.12);
            border-color: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        /* ============================================
           FORM ELEMENTS
        ============================================ */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            font-weight: 600;
            font-size: 12px;
            color: var(--text-light);
            margin-bottom: 5px;
            display: block;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .form-label .required {
            color: #ef4444;
        }

        .input-group-custom {
            position: relative;
            border: 1px solid var(--border-color);
            background: rgba(255, 255, 255, 0.03);
            transition: var(--transition);
        }

        .input-group-custom:focus-within {
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.06);
        }

        .input-group-custom .input-icon {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 15px;
            transition: var(--transition);
            z-index: 2;
            border-right: 1px solid var(--border-color);
        }

        .input-group-custom:focus-within .input-icon {
            color: var(--primary-light);
            border-color: var(--primary);
        }

        .input-group-custom .form-control {
            width: 100%;
            padding: 12px 16px 12px 52px;
            font-size: 14px;
            font-weight: 400;
            border: none;
            background: transparent;
            color: var(--text-white);
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
        }

        .input-group-custom .form-control:focus {
            outline: none;
            box-shadow: none;
        }

        .input-group-custom .form-control::placeholder {
            color: var(--text-muted);
            font-size: 13px;
        }

        .input-group-custom .form-control.is-invalid {
            border: none;
        }

        .error-text {
            font-size: 11px;
            color: #fca5a5;
            margin-top: 4px;
            display: block;
            font-weight: 500;
        }

        /* ============================================
           BUTTONS
        ============================================ */
        .btn-reset {
            width: 100%;
            padding: 14px;
            border: none;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            transition: var(--transition);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }

        .btn-reset::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.6s ease;
        }

        .btn-reset:hover::before {
            left: 100%;
        }

        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(108, 92, 231, 0.35);
        }

        .btn-reset:active {
            transform: translateY(0) scale(0.98);
        }

        .btn-reset:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-reset .spinner-border {
            width: 16px;
            height: 16px;
            border-width: 2px;
        }

        /* ============================================
           BACK TO LOGIN
        ============================================ */
        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
            color: var(--text-muted);
            font-size: 13px;
            text-decoration: none;
            transition: var(--transition);
        }

        .back-link:hover {
            color: var(--primary-light);
            gap: 12px;
        }

        .back-link i {
            font-size: 12px;
        }

        /* ============================================
           FOOTER
        ============================================ */
        .forgot-footer {
            text-align: center;
            margin-top: 24px;
        }

        .forgot-footer .version {
            font-size: 10px;
            color: var(--text-muted);
            letter-spacing: 0.5px;
        }

        /* ============================================
           RESPONSIVE
        ============================================ */
        @media (max-width: 576px) {
            .forgot-card {
                padding: 32px 24px 28px;
            }

            .logo-wrapper {
                width: 60px;
                height: 60px;
            }

            .logo-wrapper i {
                font-size: 24px;
            }

            .forgot-header h2 {
                font-size: 20px;
            }

            .forgot-header .subtitle {
                font-size: 13px;
            }

            .input-group-custom .form-control {
                padding: 10px 14px 10px 44px;
                font-size: 13px;
            }

            .input-group-custom .input-icon {
                width: 38px;
                font-size: 13px;
            }
        }

        @media (max-width: 380px) {
            .forgot-card {
                padding: 24px 16px 20px;
            }

            .forgot-header h2 {
                font-size: 18px;
            }

            .btn-reset {
                font-size: 13px;
                padding: 12px;
            }
        }

        /* ============================================
           SCROLLBAR
        ============================================ */
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
        }

        /* ============================================
           SELECTION
        ============================================ */
        ::selection {
            background: var(--primary);
            color: #fff;
        }

        /* ============================================
           AUTO-FILL
        ============================================ */
        .input-group-custom .form-control:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px rgba(16, 16, 36, 0.95) inset !important;
            -webkit-text-fill-color: #fff !important;
        }
    </style>
</head>
<body>
    <!-- ============================================
         PARTICLES
    ============================================ -->
    <div class="particles" id="particles"></div>

    <!-- ============================================
         FORGOT PASSWORD WRAPPER
    ============================================ -->
    <div class="forgot-wrapper">
        <div class="forgot-card">
            <!-- Header -->
            <div class="forgot-header">
                <div class="logo-wrapper">
                    <i class="fas fa-key"></i>
                </div>
                <h2>Reset Password</h2>
                <p class="subtitle">
                    Enter your email address and we'll send you<br>
                    a <span>password reset link</span>
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert-custom alert-success">
                    <i class="fas fa-check-circle"></i>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert-custom alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}" id="resetForm">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label">Email <span class="required">*</span></label>
                    <div class="input-group-custom">
                        <span class="input-icon"><i class="fas fa-envelope"></i></span>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="Enter your email address"
                               required 
                               autofocus
                               id="emailInput">
                    </div>
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-reset" id="resetBtn">
                    <span id="resetText">Send Reset Link</span>
                    <span id="resetSpinner" class="spinner-border d-none" role="status"></span>
                </button>
            </form>

            <!-- Back to Login -->
            <a href="{{ route('login') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Back to Login
            </a>

            <!-- Footer -->
            <div class="forgot-footer">
                <div class="version">
                    Natural Vertex ERP v1.0.0 &bull; &copy; {{ date('Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         SCRIPTS
    ============================================ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ============================================
            // PARTICLES
            // ============================================
            const container = document.getElementById('particles');
            for (let i = 0; i < 40; i++) {
                const p = document.createElement('div');
                p.className = 'particle';
                const size = Math.random() * 4 + 2;
                const duration = Math.random() * 25 + 15;
                const delay = Math.random() * 20;
                const left = Math.random() * 100;
                p.style.width = size + 'px';
                p.style.height = size + 'px';
                p.style.left = left + '%';
                p.style.animationDuration = duration + 's';
                p.style.animationDelay = delay + 's';
                container.appendChild(p);
            }

            // ============================================
            // FORM SUBMIT
            // ============================================
            const form = document.getElementById('resetForm');
            const btn = document.getElementById('resetBtn');
            const text = document.getElementById('resetText');
            const spinner = document.getElementById('resetSpinner');

            form.addEventListener('submit', function() {
                if (this.checkValidity()) {
                    btn.disabled = true;
                    text.textContent = 'Sending...';
                    spinner.classList.remove('d-none');
                }
            });

            // ============================================
            // AUTO-HIDE ALERTS
            // ============================================
            setTimeout(function() {
                document.querySelectorAll('.alert-custom').forEach(function(el) {
                    setTimeout(function() {
                        el.style.transition = 'all 0.5s ease';
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(-10px)';
                        setTimeout(function() { el.style.display = 'none'; }, 500);
                    }, 3000);
                });
            }, 100);

            // ============================================
            // KEYBOARD SHORTCUTS
            // ============================================
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.getElementById('emailInput').value = '';
                    document.getElementById('emailInput').focus();
                }
            });

            // ============================================
            // CONSOLE
            // ============================================
            console.log('%c Natural Vertex ERP - Reset Password ', 'background: #6c5ce7; color: #fff; font-size: 16px; font-weight: bold; padding: 8px 16px;');
        });
    </script>
</body>
</html>