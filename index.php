<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - VU Event Management System</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 380px; text-align: center; }
        .title-header { color: #1a237e; font-weight: bold; font-size: 16px; margin-bottom: 25px; line-height: 1.4; text-transform: uppercase; }
        h2 { color: #333; margin-bottom: 20px; font-size: 24px; }
        input, select { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 14px; }
        button { width: 100%; padding: 14px; background: #1a237e; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 10px; transition: 0.3s; }
        button:hover { background: #121858; }
        .links { margin-top: 20px; font-size: 14px; }
        .links a { color: #1a237e; text-decoration: none; font-weight: 500; }
        .links a:hover { text-decoration: underline; }
        .divider { margin: 15px 0; color: #888; font-size: 12px; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="title-header">VIRTUAL UNIVERSITY CAMPUS<br>EVENT MANAGEMENT SYSTEM</div>
        <h2>Login</h2>
        <form action="login_auth.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="">Select role</option>
                <option value="Admin">Admin</option>
                <option value="Organizer">Organizer</option>
                <option value="Student">Student</option>
            </select>
            <button type="submit">Log in</button>
        </form>
        
        <div class="links">
            <a href="forgot_password.php">Forgot Password?</a>
            <div class="divider">OR</div>
            <p>Don't have an account? <a href="signup.php">Create Account / Sign Up</a></p>
        </div>
    </div>
</body>
</html>