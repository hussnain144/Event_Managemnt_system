<?php
session_start();
include 'config.php';

// 1. Authorization Check: Sirf Admin access kar sakay
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: index.php");
    exit();
}

// 2. Query: Poore system ke events aur unke stats nikalna
$sql = "SELECT e.Title, u.Name as Organizer, e.Date,
        (SELECT COUNT(*) FROM Registrations r WHERE r.Event_ID = e.Event_ID) as Total_Reg,
        (SELECT AVG(Rating) FROM Feedback f WHERE f.Event_ID = e.Event_ID) as Avg_Rating
        FROM Events e
        JOIN Users u ON e.Organizer_ID = u.User_ID
        ORDER BY e.Date DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Query Failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Global Reports - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #1a237e; --bg: #f4f7f6; }
        body { font-family: 'Poppins', sans-serif; margin: 0; display: flex; background: var(--bg); }
        
        /* Sidebar Styling */
        .sidebar { width: 250px; background: var(--primary); color: white; height: 100vh; position: fixed; padding-top: 20px; }
        .sidebar h2 { text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; }
        .sidebar a { display: block; color: rgba(255,255,255,0.8); padding: 15px 25px; text-decoration: none; transition: 0.3s; }
        .sidebar a:hover { background: #3949ab; color: white; }

        /* Main Content */
        .main-content { margin-left: 250px; flex: 1; padding: 40px; }
        .report-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; padding: 15px; background: #f8f9fa; color: var(--primary); border-bottom: 2px solid #eee; }
        td { padding: 15px; border-bottom: 1px solid #eee; }
        .rating-star { color: #fbc02d; font-weight: bold; }
        .no-data { text-align: center; padding: 40px; color: #888; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_dashboard.php">📊 Dashboard</a>
        <a href="manage_events.php">📅 Events</a>
        <a href="view_registrations.php">👥 Registrations</a>
        <a href="view_reports_admin.php" style="background: #3949ab;">📑 Reports</a>
        <a href="logout.php">🚪 Logout</a>
    </div>

    <div class="main-content">
        <h1>Global Event Performance Reports</h1>
        
        <div class="report-card">
            <table>
                <thead>
                    <tr>
                        <th>Event Title</th>
                        <th>Organizer</th>
                        <th>Registrations</th>
                        <th>Avg. Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($row['Title']); ?></strong><br>
                                <small>📅 <?php echo date('M d, Y', strtotime($row['Date'])); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($row['Organizer']); ?></td>
                            <td><?php echo $row['Total_Reg']; ?> Students</td>
                            <td>
                                <span class="rating-star">
                                    ⭐ <?php echo ($row['Avg_Rating']) ? round($row['Avg_Rating'], 1) : "N/A"; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="no-data">System mein koi events ya registrations nahi hain.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>