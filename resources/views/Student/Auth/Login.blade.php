<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegant Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(45deg, #2193b0, #6dd5ed);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: #2193b0;
            font-size: 2em;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #666;
            font-size: 0.9em;
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: none;
            border-radius: 10px;
            background: #f5f5f5;
            color: #333;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            background: #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            outline: none;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #2193b0;
            font-size: 1.2em;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 0.9em;
        }

        .remember-me input[type="checkbox"] {
            accent-color: #2193b0;
        }

        .forgot-password {
            color: #2193b0;
            text-decoration: none;
            font-size: 0.9em;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #1a7087;
        }

        .login-button {
            width: 100%;
            padding: 15px;
            background: #2193b0;
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-button:hover {
            background: #1a7087;
            transform: translateY(-2px);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .signup-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
            font-size: 0.9em;
        }

        .signup-link a {
            color: #2193b0;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
            color: #1a7087;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            cursor: pointer;
            font-size: 1.1em;
        }

        /* Error message styling */
        .error-message {
            color: #ff4444;
            font-size: 0.85em;
            margin-top: 5px;
            display: none;
        }

        /* Success animation */
        .success-animation {
            animation: successPulse 0.5s ease;
        }

        /* Success message styling */
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.95em;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /* Error message styling */
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.95em;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /* Dismiss button styling */
        .alert .btn-close {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: inherit;
            font-size: 1.2em;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .alert .btn-c
        @keyframes successPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-header">

        {{-- message Section --}}
        @if (session('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</button>
            </div>
        @endif

        @if (session('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</button>
            </div>
        @endif

        {{-- end message Section --}}

        <h1>Welcome Back</h1>
        <p>Please sign in to continue</p>
    </div>
    <form id="loginForm" action="{{route('student.login')}}" method="post">
        @csrf
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" id="email" name = "email" placeholder="Email Address" required>
            <div class="error-message">Please enter a valid email address</div>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <div class="error-message">Password must be at least 6 characters</div>
        </div>
        <div class="remember-forgot">
            <label class="remember-me">
                <input type="checkbox" id="rememberMe">
                <span>Remember me</span>
            </label>
            <a href="#" class="forgot-password">Forgot Password?</a>
        </div>
        <button type="submit" class="login-button">Sign In</button>
    </form>
    <div class="signup-link">
        Don't have an account? <a href="{{route('student.register.page')}}">Sign Up</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loginForm = document.getElementById('loginForm');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const passwordToggle = document.getElementById('passwordToggle');
        const errorMessages = document.querySelectorAll('.error-message');

        // Toggle password visibility
        passwordToggle.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.classList.remove('fa-eye');
                passwordToggle.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordToggle.classList.remove('fa-eye-slash');
                passwordToggle.classList.add('fa-eye');
            }
        });

        // Form validation
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            let isValid = true;

            // Email validation
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(emailInput.value)) {
                emailInput.parentElement.querySelector('.error-message').style.display = 'block';
                isValid = false;
            } else {
                emailInput.parentElement.querySelector('.error-message').style.display = 'none';
            }

            // Password validation
            if (passwordInput.value.length < 6) {
                passwordInput.parentElement.querySelector('.error-message').style.display = 'block';
                isValid = false;
            } else {
                passwordInput.parentElement.querySelector('.error-message').style.display = 'none';
            }

            // If form is valid, show success animation
            if (isValid) {
                const loginContainer = document.querySelector('.login-container');
                loginContainer.classList.add('success-animation');

                // Remove animation class after it completes
                setTimeout(() => {
                    loginContainer.classList.remove('success-animation');
                    // Here you would typically handle the login logic
                    console.log('Login successful!');
                }, 500);
            }
        });

        // Clear error messages on input
        emailInput.addEventListener('input', () => {
            emailInput.parentElement.querySelector('.error-message').style.display = 'none';
        });

        passwordInput.addEventListener('input', () => {
            passwordInput.parentElement.querySelector('.error-message').style.display = 'none';
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
