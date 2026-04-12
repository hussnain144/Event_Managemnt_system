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
        // Simple password check (In real projects, use password_verify)
        if ($password == $user['Password']) {
            $_SESSION['user_id'] = $user['User_ID'];
            $_SESSION['role'] = $user['Role'];

            // Role ke hisab se redirect karein [cite: 44]
            if ($role == 'Admin') header("Location: admin_dashboard.php");
            elseif ($role == 'Organizer') header("Location: organizer_dashboard.php");
            else header("Location: student_dashboard.php");
        } else {
            echo "Invalid Password!";
        }
    } else {
        echo "No user found with this role!";
    }
}
?>