<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sql = "SELECT * FROM Users WHERE Email='$email' AND Role='$role'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifying encrypted password
        if (password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['User_ID'];
            $_SESSION['role'] = $user['Role'];
            $_SESSION['user_name'] = $user['Name'];

            if ($role == 'Admin') header("Location: admin_dashboard.php");
            elseif ($role == 'Organizer') header("Location: organizer_dashboard.php");
            else header("Location: student_dashboard.php");
        } else {
            echo "<script>alert('Invalid Password!'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('No user found with these details!'); window.location='index.php';</script>";
    }
}
?>