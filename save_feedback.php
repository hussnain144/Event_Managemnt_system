<?php
session_start();
include 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $e_id = $_POST['event_id'];
    $u_id = $_SESSION['user_id']; // Session se ID uthayi
    $rating = $_POST['rating'];
    $msg = mysqli_real_escape_string($conn, $_POST['comments']); // Security ke liye

    // Yahan 'Student_ID' use kiya hai kyunke aksar error wahi hota hai
    // Agar aapke table mein column ka naam kuch aur hai toh 'Student_ID' ki jagah wo likhein
    $sql = "INSERT INTO Feedback (Event_ID, Student_ID, Rating, Comments) VALUES ($e_id, $u_id, $rating, '$msg')";
    
    if($conn->query($sql)) {
        echo "<script>alert('Thank you for your feedback!'); window.location='student_dashboard.php';</script>";
    } else {
        // Agar ab bhi error aaye toh ye line asli wajah bata degi
        echo "Error: " . $conn->error;
    }
}
?>