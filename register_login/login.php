<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    
    if (!empty($email) && !empty($password)) {
        $database = new Database();
        $db = $database->getConnection();
        
        $query = "SELECT id, email, password FROM users WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$email]);
        
        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                redirect('dashboard.php');
            } else {
                $error_message = 'Invalid email or password.';
            }
        } else {
            $error_message = 'Invalid email or password.';
        }
    } else {
        $error_message = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Football Scouting</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --neon-blue: #0ff0fc;
            --neon-pink: #ff2a6d;
            --dark-space: #0d0221;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--dark-space);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: white;
        }

        .login-box {
            background-color: rgba(13, 2, 33, 0.9);
            padding: 2rem;
            border-radius: 8px;
            width: 300px;
            text-align: center;
            border: 1px solid var(--neon-blue);
            box-shadow: 0 0 15px rgba(13, 240, 252, 0.3);
        }

        h2 {
            color: var(--neon-blue);
            margin-bottom: 1.5rem;
        }

        .input-group {
            margin-bottom: 1rem;
            text-align: left;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #b8b8b8;
        }

        input {
            width: 100%;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            color: white;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: var(--neon-blue);
        }

        .toggle-password {
            position: absolute;
            top: 37px;
            right: 10px;
            cursor: pointer;
            color: #b8b8b8;
            font-size: 1.1rem;
            user-select: none;
        }

        .toggle-password:hover {
            color: var(--neon-blue);
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: var(--neon-blue);
            color: black;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 1rem;
            font-weight: bold;
        }

        button:hover {
            background-color: #00d4d7;
        }

        .links {
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .links a {
            color: var(--neon-blue);
            text-decoration: none;
        }

        .links a:hover {
            color: var(--neon-pink);
        }

        .error-message {
            color: var(--neon-pink);
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>LOGIN</h2>
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="your@email.com" required>
            </div>
            
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
                <span class="toggle-password" id="togglePassword">👁️</span>
            </div>
            
            <button type="submit">SIGN IN</button>
            
            <div class="links">
                <a href="forgot-password.php">Forgot password?</a> | 
                <a href="register.php">Create account</a>
            </div>
        </form>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        
        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
        });
    </script>
</body>
</html>
