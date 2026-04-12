<?php
session_start();
include 'config.php';

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_input = $_POST['email'];
    
    // 1. Database se check karein aur email fetch karein
    $sql = "SELECT Email FROM Users WHERE Email = '$email_input'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $db_email = $row['Email']; // Email fetched from database

        // 2. 4-Digit Code generate karein
        $verification_code = rand(1000, 9999);
        $conn->query("UPDATE Users SET reset_token='$verification_code' WHERE Email='$db_email'");

        // 3. PHPMailer Setup
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'husnainkhanj535@gmail.com'; // Your Gmail
            $mail->Password   = 'cmac nuzm yrya metm'; // 16-digit code without spaces
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // SSL bypass (Localhost errors ke liye zaroori)
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Recipients - Database se fetch kiya hua email yahan use ho raha hai
            $mail->setFrom('your-email@gmail.com', 'Event Management System');
            $mail->addAddress($db_email); 

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Code';
            $mail->Body    = "Your 4-digit verification code is: <b>$verification_code</b>";

            $mail->send();
            $_SESSION['reset_email'] = $db_email;
            echo "<script>alert('Code sent to $db_email'); window.location='verify_token.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Mail Error: {$mail->ErrorInfo}');</script>";
        }
    } else {
        echo "<script>alert('No account found with this email!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .box { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        input { width: 100%; padding: 12px; margin: 15px 0; border: 1px solid #ddd; border-radius: 8px; }
        button { background: #1a237e; color: white; border: none; width: 100%; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Forgot Password</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Send Code to Email</button>
        </form>
    </div>
</body>
</html>