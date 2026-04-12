<?php
session_start();
include 'config.php';

if(isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $event_id = $_GET['id'];
    $student_id = $_SESSION['user_id'];

    $sql = "DELETE FROM Registrations WHERE Event_ID = $event_id AND Student_ID = $student_id";
    
    if($conn->query($sql)) {
        header("Location: student_dashboard.php?msg=unbooked");
    }
}
?>