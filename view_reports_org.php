<?php
session_start();
include 'config.php';

// 1. Authorization Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Organizer') {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. Query ko behtar kiya hai (Aliases use kiye hain taake data asani se mile)
$sql = "SELECT e.Event_ID, e.Title, e.Date, 
        (SELECT COUNT(*) FROM Registrations r WHERE r.Event_ID = e.Event_ID) as Total_Reg,
        (SELECT AVG(Rating) FROM Feedback f WHERE f.Event_ID = e.Event_ID) as Avg_Rating
        FROM Events e 
        WHERE e.Organizer_ID = '$user_id'
        ORDER BY e.Date DESC";

$result = $conn->query($sql);

// Agar query mein masla ho toh error dikhaye
if (!$result) {
    die("Query Failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Organizer Reports</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7f6; display: flex; margin: 0; }
        .sidebar { width: 250px; background: #1a237e; color: white; height: 100vh; position: fixed; padding-top: 20px; }
        .sidebar a { display: block; color: white; padding: 15px 25px; text-decoration: none; }
        .sidebar a:hover { background: #3949ab; }
        .main-content { margin-left: 250px; padding: 40px; flex: 1; }
        .report-card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { color: #1a237e; background: #f8f9fa; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>ORGANIZER</h2>
        <a href="organizer_dashboard.php">🏠 Dashboard</a>
        <a href="view_feedback.php">⭐ Feedback</a>
        <a href="view_reports_org.php" style="background: #3949ab;">📊 Reports</a>
        <a href="logout.php">🚪 Logout</a>
    </div>

    <div class="main-content">
        <h1>My Event Reports</h1>
        <div class="report-card">
            <table>
                <thead>
                    <tr>
                        <th>Event Title</th>
                        <th>Event Date</th>
                        <th>Total Registrations</th>
                        <th>Avg. Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($row['Title']); ?></strong></td>
                            <td><?php echo date('d M, Y', strtotime($row['Date'])); ?></td>
                            <td><?php echo $row['Total_Reg']; ?> Students</td>
                            <td>⭐ <?php echo ($row['Avg_Rating']) ? round($row['Avg_Rating'], 1) : 'No Rating'; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 20px; color: #888;">
                                No events found. Please make sure you have created events. <br>
                                (Logged-in ID: <?php echo $user_id; ?>)
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>