<?php
session_start();
include 'config.php';

if (!isset($_SESSION['reset_email'])) { header("Location: forgot_password.php"); exit(); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_code = $_POST['otp_code'];
    $email = $_SESSION['reset_email'];

    // Check if the code matches what we stored in the DB
    $sql = "SELECT * FROM Users WHERE Email='$email' AND reset_token='$user_code'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['token_verified'] = true;
        header("Location: reset_password.php");
    } else {
        echo "<script>alert('Invalid Code! Check your email again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Verify Email Code</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .box { background: white; padding: 30px; border-radius: 10px; width: 350px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 10px; margin: 10px 0; font-size: 20px; text-align: center; border-radius: 5px; border: 1px solid #ccc; }
        button { background: #2e7d32; color: white; border: none; width: 100%; padding: 10px; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Enter Verification Code</h2>
        <p>Please enter the 6-digit code sent to your email.</p>
        <form method="POST">
            <input type="text" name="otp_code" placeholder="Enter Code" required maxlength="6">
            <button type="submit">Verify Code</button>
        </form>
    </div>
</body>
</html>