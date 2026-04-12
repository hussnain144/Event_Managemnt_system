<?php
include 'config.php';
session_start();

if ($_SESSION['role'] === 'Admin' && isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    
    $sql = "UPDATE Events SET Status='$status' WHERE Event_ID=$id";
    
    if ($conn->query($sql)) {
        header("Location: admin_dashboard.php?msg=Status Updated");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>