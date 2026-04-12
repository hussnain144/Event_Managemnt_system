<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up - VU Event System</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .signup-card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 420px; text-align: center; }
        .title-header { color: #1a237e; font-weight: bold; margin-bottom: 20px; text-transform: uppercase; font-size: 14px; }
        input, select { width: 100%; padding: 11px; margin: 8px 0; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 13px; background: #1a237e; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; margin-top: 10px; }
        .footer-link { margin-top: 15px; font-size: 14px; }
        .footer-link a { color: #1a237e; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="signup-card">
        <div class="title-header">Create Your Account</div>
        <form action="signup_process.php" method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address (e.g. admin@vu.edu.pk)" required>
            <input type="password" name="password" placeholder="Create Password" required>
            <input type="text" name="department" placeholder="Department (e.g. Administration / CS)" required>
            <input type="text" name="contact" placeholder="Contact Number" required>
            
            <label style="display:block; text-align:left; font-size:12px; color:#666; margin-top:5px;">Select Your Role:</label>
            <select name="role" required>
                <option value="">-- Choose Role --</option>
                <option value="Admin">Administrator</option>
                <option value="Organizer">Event Organizer</option>
                <option value="Student">Student</option>
            </select>
            
            <button type="submit">Register Now</button>
        </form>
        <div class="footer-link">
            Already have an account? <a href="index.php">Log in</a>
        </div>
    </div>
</body>
</html>