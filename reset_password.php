<?php
session_start();
include 'config.php';

// Security check
if (!isset($_SESSION['token_verified'])) { 
    header("Location: forgot_password.php"); 
    exit(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];
    $email = $_SESSION['reset_email'];

    if ($pass === $confirm_pass) {
        
        /**
         * FIX: Use password_hash instead of md5.
         * This creates a secure Bcrypt hash that matches your login_auth.php code.
         */
        $secure_hash = password_hash($pass, PASSWORD_DEFAULT); 
        
        // Update database with the SECURE HASH
        $sql = "UPDATE Users SET Password='$secure_hash', reset_token=NULL WHERE Email='$email'";
        
        if ($conn->query($sql)) {
            session_destroy();
            echo "<script>alert('Password Reset Successful! Try logging in now.'); window.location='index.php';</script>";
        } else {
            $error = "Database Error: Could not update.";
        }
    } else {
        $error = "Passwords do not match!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Set New Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Modern UI Styling */
        body { font-family: 'Poppins', sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .reset-box { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 350px; }
        h2 { color: #1a237e; text-align: center; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn { background: #2e7d32; color: white; border: none; width: 100%; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: 600; transition: 0.3s; }
        .btn:hover { background: #1b5e20; }
        .error { color: #d32f2f; font-size: 13px; text-align: center; background: #ffebee; padding: 8px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="reset-box">
        <h2>Set New Password</h2>
        <p style="text-align: center; font-size: 13px;">Resetting password for: <br><strong><?php echo $_SESSION['reset_email']; ?></strong></p>
        
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        
        <form method="POST">
            <input type="password" name="password" placeholder="New Password" required minlength="4">
            <input type="password" name="confirm_password" placeholder="Confirm Password" required minlength="4">
            <button type="submit" class="btn">Update Password</button>
        </form>
    </div>
</body>
</html>