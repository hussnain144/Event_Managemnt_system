<?php
session_start();
include 'config.php';

if (!isset($_GET['id'])) { header("Location: organizer_dashboard.php"); exit(); }

$event_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Purana data fetch karna
$res = $conn->query("SELECT * FROM Events WHERE Event_ID = $event_id AND Organizer_ID = $user_id");
$data = $res->fetch_assoc();

if (!$data) { echo "Event not found or access denied!"; exit(); }

// Update Logic
if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $venue = $_POST['venue'];
    $date = $_POST['date'];
    $desc = $_POST['description'];

    $update_sql = "UPDATE Events SET Title='$title', Venue='$venue', Date='$date', Description='$desc', Status='Pending' WHERE Event_ID=$event_id";
    
    if ($conn->query($update_sql)) {
        echo "<script>alert('Event updated and sent for re-approval!'); window.location='organizer_dashboard.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7f6; padding: 40px; }
        .form-container { max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { background: #1a237e; color: white; border: none; padding: 12px 20px; border-radius: 5px; cursor: pointer; width: 100%; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Event Details</h2>
        <form method="POST">
            <label>Event Title</label>
            <input type="text" name="title" value="<?php echo $data['Title']; ?>" required>
            
            <label>Venue</label>
            <input type="text" name="venue" value="<?php echo $data['Venue']; ?>" required>
            
            <label>Date</label>
            <input type="date" name="date" value="<?php echo $data['Date']; ?>" required>
            
            <label>Description</label>
            <textarea name="description" rows="4"><?php echo $data['Description']; ?></textarea>
            
            <button type="submit" name="update">Save Changes</button>
            <a href="organizer_dashboard.php" style="display:block; text-align:center; margin-top:15px; color:#666; text-decoration:none;">Cancel</a>
        </form>
    </div>
</body>
</html>