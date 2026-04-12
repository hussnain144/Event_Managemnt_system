<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    // Password encryption as per requirement #71
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $dept = $_POST['department'];
    $contact = $_POST['contact'];
    $role = $_POST['role'];

    // Check if email already exists
    $checkEmail = "SELECT * FROM Users WHERE Email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already registered!'); window.location='signup.php';</script>";
    } else {
        $sql = "INSERT INTO Users (Name, Email, Password, Role, Department, Contact_No) 
                VALUES ('$name', '$email', '$password', '$role', '$dept', '$contact')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Account created successfully! Please login.'); window.location='index.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>