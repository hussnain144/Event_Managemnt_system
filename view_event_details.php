<?php
session_start();
include 'config.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$event_id = $_GET['id'];

// Query to get event details along with Organizer name
$sql = "SELECT Events.*, Users.Name as OrganizerName 
        FROM Events 
        JOIN Users ON Events.Organizer_ID = Users.User_ID 
        WHERE Events.Event_ID = $event_id";

$result = $conn->query($sql);
$event = $result->fetch_assoc();

if (!$event) {
    echo "Event not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Details - <?php echo $event['Title']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7f9; margin: 0; padding: 50px; }
        .details-container { 
            max-width: 800px; 
            margin: 0 auto; 
            background: white; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
        }
        .header { border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { color: #1a237e; margin: 0; }
        .status-badge { 
            display: inline-block; 
            padding: 5px 15px; 
            border-radius: 20px; 
            font-size: 14px; 
            font-weight: 600; 
            background: #e8f5e9; color: #2e7d32; 
        }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 30px; }
        .info-item { background: #f8f9fa; padding: 15px; border-radius: 10px; }
        .info-item label { display: block; color: #888; font-size: 12px; text-transform: uppercase; }
        .info-item span { font-weight: 600; color: #333; }
        .description { margin-top: 30px; line-height: 1.6; color: #555; }
        .back-btn { 
            display: inline-block; 
            margin-top: 30px; 
            text-decoration: none; 
            color: #1a237e; 
            font-weight: 600; 
        }
    </style>
</head>
<body>

<div class="details-container">
    <div class="header">
        <span class="status-badge"><?php echo $event['Status']; ?></span>
        <h1><?php echo htmlspecialchars($event['Title']); ?></h1>
    </div>

    <div class="info-grid">
        <div class="info-item">
            <label>Organizer</label>
            <span><?php echo htmlspecialchars($event['OrganizerName']); ?></span>
        </div>
        <div class="info-item">
            <label>Date</label>
            <span><?php echo date('F d, Y', strtotime($event['Date'])); ?></span>
        </div>
        <div class="info-item">
            <label>Time</label>
            <span><?php echo date('h:i A', strtotime($event['Time'])); ?></span>
        </div>
        <div class="info-item">
            <label>Venue</label>
            <span><?php echo htmlspecialchars($event['Venue']); ?></span>
        </div>
    </div>

    <div class="description">
        <h3>Description</h3>
        <p><?php echo nl2br(htmlspecialchars($event['Description'])); ?></p>
    </div>

    <a href="javascript:history.back()" class="back-btn">← Back to Dashboard</a>
</div>

</body>
</html>