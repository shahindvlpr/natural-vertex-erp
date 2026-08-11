{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Natural Vertex ERP - Login</title>
    
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
           LOGIN WRAPPER
        ============================================ */
        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 460px;
            padding: 20px;
        }

        .login-card {
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
        .login-card::before {
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
           LOGIN HEADER
        ============================================ */
        .login-header {
            text-align: center;
            margin-bottom: 36px;
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
            font-size: 32px;
            color: #fff;
        }

        .login-header h2 {
            color: var(--text-white);
            font-weight: 800;
            font-size: 24px;
            letter-spacing: -0.5px;
            margin-bottom: 2px;
        }

        .login-header .subtitle {
            color: var(--text-light);
            font-size: 13px;
            font-weight: 400;
            letter-spacing: 0.3px;
        }

        .login-header .subtitle span {
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

        .alert-custom.alert-danger {
            background: rgba(239, 68, 68, 0.12);
            border-color: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        .alert-custom.alert-success {
            background: rgba(16, 185, 129, 0.12);
            border-color: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
        }

        /* ============================================
           FORM ELEMENTS
        ============================================ */
        .form-group {
            margin-bottom: 20px;
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

        .input-group-custom .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: var(--text-muted);
            padding: 6px 8px;
            cursor: pointer;
            transition: var(--transition);
            z-index: 2;
        }

        .input-group-custom .toggle-password:hover {
            color: var(--text-white);
        }

        .error-text {
            font-size: 11px;
            color: #fca5a5;
            margin-top: 4px;
            display: block;
            font-weight: 500;
        }

        /* ============================================
           OPTIONS
        ============================================ */
        .options-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .custom-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-light);
            transition: var(--transition);
            user-select: none;
        }

        .custom-checkbox:hover {
            color: var(--text-white);
        }

        .custom-checkbox input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border: 2px solid var(--text-muted);
            cursor: pointer;
            transition: var(--transition);
            accent-color: var(--primary);
            background: transparent;
        }

        .custom-checkbox input[type="checkbox"]:checked {
            border-color: var(--primary);
        }

        .forgot-link {
            font-size: 13px;
            font-weight: 500;
            color: var(--primary-light);
            text-decoration: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .forgot-link:hover {
            color: var(--secondary);
            gap: 8px;
        }

        /* ============================================
           LOGIN BUTTON
        ============================================ */
        .btn-login {
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

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.6s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(108, 92, 231, 0.35);
        }

        .btn-login:active {
            transform: translateY(0) scale(0.98);
        }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-login .spinner-border {
            width: 16px;
            height: 16px;
            border-width: 2px;
        }

        /* ============================================
           SOCIAL LOGIN
        ============================================ */
        .divider-wrapper {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 24px 0;
        }

        .divider-wrapper .divider-line {
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }

        .divider-wrapper .divider-text {
            font-size: 11px;
            font-weight: 500;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            white-space: nowrap;
        }

        .social-login-wrapper {
            display: flex;
            gap: 12px;
        }

        .btn-social {
            flex: 1;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            background: rgba(255, 255, 255, 0.03);
            font-size: 13px;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            transition: var(--transition);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: var(--text-light);
            text-decoration: none;
        }

        .btn-social:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .btn-social i {
            font-size: 18px;
        }

        .btn-social.btn-google i { color: #ea4335; }
        .btn-social.btn-google:hover i { color: #ea4335; }

        .btn-social.btn-github i { color: #8b949e; }
        .btn-social.btn-github:hover i { color: #8b949e; }

        .btn-social.btn-microsoft i { color: #00a4ef; }
        .btn-social.btn-microsoft:hover i { color: #00a4ef; }

        /* ============================================
           FOOTER
        ============================================ */
        .login-footer {
            text-align: center;
            margin-top: 24px;
        }

        .login-footer .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            color: var(--text-muted);
            padding: 4px 16px;
            border: 1px solid var(--border-color);
        }

        .login-footer .security-badge i {
            color: #10b981;
        }

        .login-footer .version {
            margin-top: 10px;
            font-size: 10px;
            color: var(--text-muted);
            letter-spacing: 0.5px;
        }

        .info-note {
            text-align: center;
            margin-top: 14px;
            font-size: 11px;
            color: var(--text-muted);
        }

        .info-note i {
            color: var(--primary-light);
            margin-right: 4px;
        }

        .info-note strong {
            color: var(--text-light);
        }

        /* ============================================
           RESPONSIVE
        ============================================ */
        @media (max-width: 576px) {
            .login-card {
                padding: 32px 24px 28px;
            }

            .logo-wrapper {
                width: 60px;
                height: 60px;
            }

            .logo-wrapper i {
                font-size: 26px;
            }

            .login-header h2 {
                font-size: 20px;
            }

            .options-wrapper {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }

            .social-login-wrapper {
                flex-direction: column;
            }

            .btn-social {
                padding: 8px 12px;
                font-size: 12px;
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
            .login-card {
                padding: 24px 16px 20px;
            }

            .login-header h2 {
                font-size: 18px;
            }

            .btn-login {
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
</div>
    <div class="login-wrapper">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="logo-wrapper">
                    <i class="fas fa-cubes"></i>
                </div>
                <h2>Natural Vertex</h2>
                <p class="subtitle">
                    Enterprise Resource Planning <span>System</span>
                </p>
            </div>

            <!-- Alerts -->
            @if ($errors->any())
                <div class="alert-custom alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            @if (session('status'))
                <div class="alert-custom alert-success">
                    <i class="fas fa-check-circle"></i>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" id="loginForm">
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
                               placeholder="Enter your email"
                               required 
                               autofocus
                               id="emailInput">
                    </div>
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label">Password <span class="required">*</span></label>
                    <div class="input-group-custom">
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               name="password" 
                               id="passwordInput"
                               placeholder="Enter your password"
                               required>
                        <button type="button" class="toggle-password" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Options -->
                <div class="options-wrapper">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="remember" id="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="forgot-link">
                        Forgot Password?
                    </a>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-login" id="loginBtn">
                    <span id="loginText">Sign In</span>
                    <span id="loginSpinner" class="spinner-border d-none" role="status"></span>
                </button>
            </form>

            <!-- Social Login -->
            <div class="divider-wrapper">
                <span class="divider-line"></span>
                <span class="divider-text">Or</span>
                <span class="divider-line"></span>
            </div>

            <div class="social-login-wrapper">
                <a href="{{ route('auth.google') }}" class="btn-social btn-google">
                    <i class="fab fa-google"></i> Google
                </a>
                <a href="#" class="btn-social btn-github">
                    <i class="fab fa-github"></i> GitHub
                </a>
                <a href="#" class="btn-social btn-microsoft">
                    <i class="fab fa-microsoft"></i> Microsoft
                </a>
            </div>

            <!-- Info -->
            <div class="info-note">
                <i class="fas fa-shield-alt"></i>
                <span>Secure access • Managed by <strong>Administrators</strong></span>
            </div>

            <!-- Footer -->
            <div class="login-footer">
                <div class="security-badge">
                    <i class="fas fa-check-circle"></i>
                    <span>2FA Available</span>
                </div>
                <div class="version">
                    v1.0.0 &bull; &copy; {{ date('Y') }} Natural Vertex Ltd.
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
            // PASSWORD TOGGLE
            // ============================================
            const toggleBtn = document.getElementById('togglePassword');
            const passInput = document.getElementById('passwordInput');
            let visible = false;

            toggleBtn.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (visible) {
                    passInput.type = 'password';
                    icon.className = 'fas fa-eye';
                } else {
                    passInput.type = 'text';
                    icon.className = 'fas fa-eye-slash';
                }
                visible = !visible;
            });

            // ============================================
            // FORM SUBMIT
            // ============================================
            const form = document.getElementById('loginForm');
            const btn = document.getElementById('loginBtn');
            const text = document.getElementById('loginText');
            const spinner = document.getElementById('loginSpinner');

            form.addEventListener('submit', function() {
                if (this.checkValidity()) {
                    btn.disabled = true;
                    text.textContent = 'Signing in...';
                    spinner.classList.remove('d-none');
                }
            });

            // ============================================
            // AUTO-HIDE ALERTS
            // ============================================
            setTimeout(function() {
                document.querySelectorAll('.alert-custom').forEach(function(el, i) {
                    setTimeout(function() {
                        el.style.transition = 'all 0.5s ease';
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(-10px)';
                        setTimeout(function() { el.style.display = 'none'; }, 500);
                    }, i * 200 + 3000);
                });
            }, 100);

            // ============================================
            // KEYBOARD SHORTCUTS
            // ============================================
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.shiftKey && e.key === 'L') {
                    e.preventDefault();
                    document.getElementById('emailInput').focus();
                }
                if (e.key === 'Escape') {
                    document.getElementById('emailInput').value = '';
                    document.getElementById('passwordInput').value = '';
                    document.getElementById('emailInput').focus();
                }
            });

            // ============================================
            // CONSOLE
            // ============================================
            console.log('%c Natural Vertex ERP v1.0.0 ', 'background: #6c5ce7; color: #fff; font-size: 18px; font-weight: bold; padding: 8px 16px;');
            console.log('%c Enterprise Resource Planning System ', 'color: #a29bfe; font-size: 13px;');
        });
    </script>
</body>
</html>