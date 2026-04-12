<?php
session_start();
include 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Organizer') {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Sab se pehle Organizer ke Approved events uthao
$sql = "SELECT * FROM Events WHERE Organizer_ID = '$user_id' AND Status = 'Approved'";
$events = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Attendance</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7f6; display: flex; margin: 0; }
        .sidebar { width: 250px; background: #1a237e; color: white; height: 100vh; position: fixed; }
        .sidebar a { display: block; color: white; padding: 15px; text-decoration: none; }
        .main-content { margin-left: 250px; padding: 40px; flex: 1; }
        .event-card { background: white; padding: 20px; border-radius: 10px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .btn { background: #1a237e; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>ORGANIZER</h2>
        <a href="organizer_dashboard.php">🏠 Dashboard</a>
        <a href="manage_attendance.php" style="background: #3949ab;">📝 Attendance</a>
        <a href="view_reports_org.php">📊 Reports</a>
        <a href="logout.php">🚪 Logout</a>
    </div>

    <div class="main-content">
        <h1>Mark Attendance</h1>
        <p>Select an event to mark attendance for registered students:</p>

        <?php while($row = $events->fetch_assoc()): ?>
        <div class="event-card">
            <div>
                <strong><?php echo htmlspecialchars($row['Title']); ?></strong><br>
                <small>📅 <?php echo $row['Date']; ?></small>
            </div>
            <a href="mark_students.php?event_id=<?php echo $row['Event_ID']; ?>" class="btn">View Students</a>
        </div>
        <?php endwhile; ?>
    </div>
</body>
</html>