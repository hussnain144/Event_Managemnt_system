<?php
session_start();
include 'config.php';

if(isset($_GET['id'])) {
    $event_id = $_GET['id'];
    
    // Yahan hum database mein aik 'reminder_sent' ka column update kar sakte hain
    // Ya phir real-time notification socket (pusher) use kar sakte hain.
    // Filhaal hum status update karte hain taake student dashboard par alert dikhaye.
    
    $sql = "UPDATE Registrations SET Reminder_Status = 1 WHERE Event_ID = $event_id";
    
    if($conn->query($sql)) {
        header("Location: organizer_dashboard.php?msg=Reminders Sent Successfully");
    }
}
?>