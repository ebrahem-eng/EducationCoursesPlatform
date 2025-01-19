<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* All the same styles as before */
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

        .signup-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .signup-container:hover {
            transform: translateY(-5px);
        }

        .signup-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .signup-header h1 {
            color: #2193b0;
            font-size: 2em;
            margin-bottom: 10px;
        }

        .signup-header p {
            color: #666;
            font-size: 0.9em;
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group input, .input-group select {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: none;
            border-radius: 10px;
            background: #f5f5f5;
            color: #333;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .input-group input:focus, .input-group select:focus {
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

        .signup-button {
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

        .signup-button:hover {
            background: #1a7087;
            transform: translateY(-2px);
        }

        .signup-button:active {
            transform: translateY(0);
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
            font-size: 0.9em;
        }

        .login-link a {
            color: #2193b0;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #1a7087;
        }

        .error-message {
            color: #ff4444;
            font-size: 0.85em;
            margin-top: 5px;
            display: none;
        }

        .success-animation {
            animation: successPulse 0.5s ease;
        }

        @keyframes successPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
<div class="signup-container">
    <div class="signup-header">
        <h1>Create Account</h1>
        <p>Please fill in your details to register</p>
    </div>
    <!-- Added ID to the form -->
    <form id="signupForm" action="{{route('student.register')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" id="name" name="name" placeholder="Full Name" required>
            <div class="error-message">Name is required</div>
        </div>

        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" id="email" name="email" placeholder="Email Address" required>
            <div class="error-message">Please enter a valid email address</div>
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <div class="error-message">Password must be at least 6 characters</div>
        </div>

        <div class="input-group">
            <i class="fas fa-venus-mars"></i>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="1">Male</option>
                <option value="0">Female</option>
            </select>
            <div class="error-message">Please select your gender</div>
        </div>

        <div class="input-group">
            <i class="fas fa-calendar"></i>
            <input type="number" id="age" name="age" placeholder="Age" min="1" max="150" required>
            <div class="error-message">Please enter a valid age</div>
        </div>

        <div class="input-group">
            <i class="fas fa-phone"></i>
            <input type="tel" id="phone" name="phone" placeholder="Phone Number" required>
            <div class="error-message">Please enter a valid phone number</div>
        </div>

        <div class="input-group">
            <i class="fas fa-image"></i>
            <input type="file" id="image" name="image" accept="image/*" required>
            <div class="error-message">Please select an image</div>
        </div>

        <button type="submit" class="signup-button">Create Account</button>
    </form>
    <div class="login-link">
        Already have an account? <a href="{{route('student.login.page')}}">Login</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('signupForm');
        const inputs = form.querySelectorAll('input, select');

        // Form validation
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            let isValid = true;

            // Reset all error messages
            document.querySelectorAll('.error-message').forEach(msg => {
                msg.style.display = 'none';
            });

            // Validate each input
            inputs.forEach(input => {
                const errorMessage = input.parentElement.querySelector('.error-message');

                switch(input.id) {
                    case 'email':
                        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailPattern.test(input.value)) {
                            errorMessage.style.display = 'block';
                            isValid = false;
                        }
                        break;

                    case 'password':
                        if (input.value.length < 6) {
                            errorMessage.style.display = 'block';
                            isValid = false;
                        }
                        break;

                    case 'phone':
                        const phonePattern = /^\d{10}$/;
                        if (!phonePattern.test(input.value)) {
                            errorMessage.style.display = 'block';
                            isValid = false;
                        }
                        break;

                    case 'age':
                        if (input.value < 1 || input.value > 150) {
                            errorMessage.style.display = 'block';
                            isValid = false;
                        }
                        break;

                    case 'gender':
                        if (!input.value) {
                            errorMessage.style.display = 'block';
                            isValid = false;
                        }
                        break;

                    default:
                        if (!input.value) {
                            errorMessage.style.display = 'block';
                            isValid = false;
                        }
                }
            });

            if (isValid) {
                const container = document.querySelector('.signup-container');
                container.classList.add('success-animation');

                // Actually submit the form after validation
                setTimeout(() => {
                    form.submit();
                }, 500);
            }
        });

        // Clear error messages on input
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                const errorMessage = input.parentElement.querySelector('.error-message');
                errorMessage.style.display = 'none';
            });
        });
    });
</script>
</body>
</html>
