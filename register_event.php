<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $student_id = $_SESSION['user_id'];

    // 1. Check karein ke student ne pehle hi register to nahi kiya
    $check_query = "SELECT * FROM Registrations WHERE Event_ID = $event_id AND Student_ID = $student_id";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        echo "<script>alert('You are already registered for this event!'); window.location='student_dashboard.php';</script>";
    } else {
        // 2. Registration insert karein
        $insert_sql = "INSERT INTO Registrations (Event_ID, Student_ID) VALUES ($event_id, $student_id)";
        
        if ($conn->query($insert_sql) === TRUE) {
            echo "<script>alert('Registration Successful!'); window.location='student_dashboard.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>