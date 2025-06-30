<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmPassword'];
    
    // Validation
    if (empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Please enter a valid email address.';
    } elseif (strlen($password) < 8) {
        $error_message = 'Password must be at least 8 characters long.';
    } elseif ($password !== $confirm_password) {
        $error_message = 'Passwords do not match.';
    } else {
        $database = new Database();
        $db = $database->getConnection();
        
        // Check if email already exists
        $check_query = "SELECT id FROM users WHERE email = ?";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->execute([$email]);
        
        if ($check_stmt->fetch()) {
            $error_message = 'Email address already registered.';
        } else {
            // Create new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_query = "INSERT INTO users (email, password) VALUES (?, ?)";
            $insert_stmt = $db->prepare($insert_query);
            
            if ($insert_stmt->execute([$email, $hashed_password])) {
                $success_message = 'Registration successful! You can now log in.';
            } else {
                $error_message = 'Registration failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Football Scouting</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #0d0221;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(255, 42, 109, 0.15) 0%, transparent 25%),
                radial-gradient(circle at 80% 70%, rgba(5, 217, 232, 0.15) 0%, transparent 25%);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: rgba(13, 2, 33, 0.9);
            border: 1px solid #05d9e8;
            border-radius: 8px;
            padding: 30px;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 0 15px rgba(5, 217, 232, 0.5),
                        0 0 30px rgba(255, 42, 109, 0.3);
        }

        h1 {
            color: #05d9e8;
            text-align: center;
            margin-bottom: 25px;
            text-shadow: 0 0 10px rgba(5, 217, 232, 0.7);
            font-size: 2rem;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #f4ebee;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            background-color: rgba(5, 1, 15, 0.7);
            border: 1px solid #05d9e8;
            border-radius: 4px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #f4ecee;
            box-shadow: 0 0 10px rgba(255, 42, 109, 0.5);
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 10px;
            cursor: pointer;
            color: #05d9e8;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            user-select: none;
        }

        .toggle-password:hover {
            color: #ff2a6d;
            transform: scale(1.1);
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #d7db61, #d300c5);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
            margin-top: 10px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        button:hover {
            background: linear-gradient(135deg, #05d9e8, #c100b5);
            box-shadow: 0 0 15px rgba(255, 42, 109, 0.5);
            transform: translateY(-2px);
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #b8b8b8;
        }

        .login-link a {
            color: #05d9e8;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: #ff2a6d;
            text-shadow: 0 0 5px rgba(255, 42, 109, 0.5);
        }

        .error-message {
            color: #ff2a6d;
            font-size: 0.9rem;
            margin-bottom: 15px;
            text-align: center;
        }

        .success-message {
            color: #05d9e8;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .password-strength {
            height: 4px;
            background-color: #1a0933;
            margin-top: 8px;
            border-radius: 2px;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0%;
            background-color: #ff2a6d;
            transition: width 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>CREATE ACCOUNT</h1>
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="your@email.com" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                    <span class="toggle-password" id="togglePassword">👁️</span>
                </div>
                <div class="password-strength">
                    <div class="strength-bar" id="strengthBar"></div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <div class="password-container">
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="••••••••" required>
                    <span class="toggle-password" id="toggleConfirmPassword">👁️</span>
                </div>
            </div>
            
            <button type="submit">REGISTER</button>
            
            <div class="login-link">
                Already have an account? <a href="login.php">Login here</a>
            </div>
        </form>
    </div>

    <script>
        // Password visibility toggles
        function setupPasswordToggle(toggleElement, inputElement) {
            toggleElement.addEventListener('click', function() {
                const type = inputElement.getAttribute('type') === 'password' ? 'text' : 'password';
                inputElement.setAttribute('type', type);
                toggleElement.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
            });
        }

        setupPasswordToggle(document.getElementById('togglePassword'), document.getElementById('password'));
        setupPasswordToggle(document.getElementById('toggleConfirmPassword'), document.getElementById('confirmPassword'));

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength += 25;
            if (password.length >= 12) strength += 15;
            if (/[A-Z]/.test(password)) strength += 15;
            if (/[0-9]/.test(password)) strength += 15;
            if (/[^A-Za-z0-9]/.test(password)) strength += 15;
            
            const strengthBar = document.getElementById('strengthBar');
            strengthBar.style.width = Math.min(strength, 100) + '%';
            
            if (strength < 40) {
                strengthBar.style.backgroundColor = '#ff2a6d';
            } else if (strength < 70) {
                strengthBar.style.backgroundColor = '#ffcc00';
            } else {
                strengthBar.style.backgroundColor = '#05d9e8';
            }
        });
    </script>
</body>
</html>
