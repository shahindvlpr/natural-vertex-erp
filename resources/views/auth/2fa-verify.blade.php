{{-- resources/views/auth/2fa-verify.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>2FA Verification - Natural Vertex ERP</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .verify-container {
            width: 100%;
            max-width: 440px;
            padding: 15px;
        }
        .verify-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px 35px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: slideUp 0.6s ease;
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
        .verify-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .verify-icon i {
            font-size: 40px;
            color: white;
        }
        .verify-title {
            color: #333;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .verify-subtitle {
            color: #888;
            font-size: 14px;
            margin-bottom: 25px;
        }
        .code-inputs {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 25px;
        }
        .code-input {
            width: 50px;
            height: 60px;
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            transition: all 0.3s;
            background: #f8f9fa;
        }
        .code-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
            outline: none;
            background: white;
        }
        .code-input-filled {
            border-color: #667eea;
            background: white;
        }
        .btn-verify {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            width: 100%;
            transition: all 0.3s;
            font-size: 16px;
        }
        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .btn-verify:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .resend-link {
            color: #667eea;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        .resend-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        .timer {
            color: #999;
            font-size: 14px;
            margin-top: 10px;
        }
        .alert {
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .back-link {
            color: #888;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link:hover {
            color: #667eea;
        }
        
        @media (max-width: 480px) {
            .verify-card {
                padding: 30px 20px;
            }
            .code-input {
                width: 40px;
                height: 50px;
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="verify-container">
        <div class="verify-card">
            <!-- Icon -->
            <div class="verify-icon">
                <i class="fas fa-shield-alt"></i>
            </div>

            <h3 class="verify-title">Two-Factor Authentication</h3>
            <p class="verify-subtitle">
                Enter the 6-digit verification code sent to your email
            </p>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Verification Form -->
            <form method="POST" action="{{ route('2fa.verify') }}" id="verifyForm">
                @csrf
                
                <div class="code-inputs" id="codeInputs">
                    <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                    <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                    <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                    <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                    <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                    <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                </div>
                <input type="hidden" name="code" id="codeHidden">

                <button type="submit" class="btn-verify" id="verifyBtn">
                    <span id="verifyText">Verify Code</span>
                    <span id="verifySpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                </button>
            </form>

            <!-- Resend and Timer -->
            <div class="mt-3">
                <div class="timer" id="timer">
                    <i class="fas fa-clock me-1"></i>
                    <span id="timerText">Resend code in 60s</span>
                </div>
                <a href="#" class="resend-link" id="resendLink" style="display: none;">
                    <i class="fas fa-redo me-1"></i> Resend Code
                </a>
            </div>

            <!-- Back to Login -->
            <div class="mt-4">
                <a href="{{ route('login') }}" class="back-link">
                    <i class="fas fa-arrow-left me-1"></i> Back to Login
                </a>
            </div>
        </div>
    </div>

    <script>
        // Auto-focus and handle input
        const inputs = document.querySelectorAll('.code-input');
        const hiddenInput = document.getElementById('codeHidden');
        let timer = 60;
        let timerInterval;

        // Focus first input on load
        inputs[0].focus();

        // Handle input event
        inputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                // Only allow numbers
                this.value = this.value.replace(/[^0-9]/g, '');
                
                if (this.value.length === 1) {
                    // Move to next input
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
                
                // Update hidden input
                updateHiddenCode();
                
                // Auto-submit when all fields filled
                if (getFullCode().length === 6) {
                    document.getElementById('verifyForm').submit();
                }
            });

            // Handle backspace
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value === '' && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            // Handle paste
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text');
                const numbers = paste.replace(/[^0-9]/g, '').slice(0, 6);
                
                numbers.split('').forEach((num, i) => {
                    if (i < inputs.length) {
                        inputs[i].value = num;
                        inputs[i].classList.add('code-input-filled');
                    }
                });
                
                updateHiddenCode();
                
                // Focus next empty input or submit
                const nextEmpty = Array.from(inputs).find(input => input.value === '');
                if (nextEmpty) {
                    nextEmpty.focus();
                } else {
                    document.getElementById('verifyForm').submit();
                }
            });

            // Add filled class
            input.addEventListener('focus', function() {
                this.select();
            });
        });

        function updateHiddenCode() {
            const code = getFullCode();
            hiddenInput.value = code;
            
            // Update input styling
            inputs.forEach(input => {
                if (input.value) {
                    input.classList.add('code-input-filled');
                } else {
                    input.classList.remove('code-input-filled');
                }
            });
        }

        function getFullCode() {
            let code = '';
            inputs.forEach(input => {
                code += input.value;
            });
            return code;
        }

        // Timer countdown
        function startTimer() {
            timer = 60;
            const timerText = document.getElementById('timerText');
            const resendLink = document.getElementById('resendLink');
            
            timerInterval = setInterval(() => {
                timer--;
                timerText.textContent = `Resend code in ${timer}s`;
                
                if (timer <= 0) {
                    clearInterval(timerInterval);
                    timerText.textContent = 'Code expired';
                    resendLink.style.display = 'inline-block';
                }
            }, 1000);
        }

        // Resend code
        document.getElementById('resendLink').addEventListener('click', function(e) {
            e.preventDefault();
            
            fetch('{{ route("2fa.resend") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reset inputs
                    inputs.forEach(input => {
                        input.value = '';
                        input.classList.remove('code-input-filled');
                    });
                    inputs[0].focus();
                    
                    // Reset timer
                    this.style.display = 'none';
                    startTimer();
                    
                    // Show success message
                    const alert = document.createElement('div');
                    alert.className = 'alert alert-success mt-3';
                    alert.innerHTML = '<i class="fas fa-check-circle me-2"></i> New code sent to your email';
                    document.querySelector('.verify-card').insertBefore(alert, document.querySelector('.mt-3'));
                    
                    setTimeout(() => {
                        alert.remove();
                    }, 5000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        // Form submission loading state
        document.getElementById('verifyForm').addEventListener('submit', function() {
            const btn = document.getElementById('verifyBtn');
            const text = document.getElementById('verifyText');
            const spinner = document.getElementById('verifySpinner');
            
            btn.disabled = true;
            text.textContent = 'Verifying...';
            spinner.classList.remove('d-none');
        });

        // Start timer
        startTimer();
    </script>
</body>
</html>