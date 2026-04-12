<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $venue = $_POST['venue'];
    $capacity = $_POST['capacity'];
    $org_id = $_SESSION['user_id'];

    $sql = "INSERT INTO Events (Title, Description, Date, Time, Venue, Capacity, Status, Organizer_ID) 
            VALUES ('$title', '$desc', '$date', '$time', '$venue', $capacity, 'Pending', $org_id)";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Event submitted! Waiting for Admin approval.'); window.location='organizer_dashboard.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>