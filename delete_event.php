<?php
session_start();
include 'config.php';

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $event_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];

    // Security Check: Organizer sirf apna event delete kar sake
    $check_sql = "SELECT Organizer_ID FROM Events WHERE Event_ID = $event_id";
    $res = $conn->query($check_sql);
    $event_data = $res->fetch_assoc();

    if ($role === 'Admin' || ($role === 'Organizer' && $event_data['Organizer_ID'] == $user_id)) {
        
        // Step 1: Pehle is event se judi Feedback delete karein
        $conn->query("DELETE FROM Feedback WHERE Event_ID = $event_id");

        // Step 2: Phir is event ki Registrations delete karein
        $conn->query("DELETE FROM Registrations WHERE Event_ID = $event_id");

        // Step 3: Ab Event ko delete karein
        $sql = "DELETE FROM Events WHERE Event_ID = $event_id";

        if ($conn->query($sql) === TRUE) {
            $redirect = ($role === 'Admin') ? "admin_dashboard.php" : "organizer_dashboard.php";
            header("Location: $redirect?msg=deleted");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Unauthorized access!";
    }
} else {
    header("Location: index.php");
}
?>