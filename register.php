<?php
include 'config.php';
session_start();
$eid = $_GET['id'];
$sid = $_SESSION['user_id'];

// Capacity check
$q = $conn->query("SELECT Capacity, (SELECT COUNT(*) FROM Registration WHERE Event_ID=$eid) as reg FROM Events WHERE Event_ID=$eid")->fetch_assoc();

if($q['reg'] < $q['Capacity']) {
    $conn->query("INSERT INTO Registration (Event_ID, Student_ID, Registration_Date, Status) VALUES ($eid, $sid, CURDATE(), 'Registered')");
    echo "<script>alert('Registered Successfully!'); window.location='student_dashboard.php';</script>";
} else {
    echo "<script>alert('Event Full!'); window.location='student_dashboard.php';</script>";
}
?>