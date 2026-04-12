<?php
session_start();
include 'config.php';

// 1. Authorization Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: index.php");
    exit();
}

// 2. Registrations Fetch karna (Simplified Query)
// Maine date nikal di hai taake error na aaye
$sql = "SELECT Users.Name as Student_Name, Events.Title as Event_Title 
        FROM Registrations
        JOIN Users ON Registrations.Student_ID = Users.User_ID
        JOIN Events ON Registrations.Event_ID = Events.Event_ID";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Registrations - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #1a237e; --accent: #3949ab; --bg: #f4f7f6; }
        body { font-family: 'Poppins', sans-serif; margin: 0; display: flex; background: var(--bg); }
        .sidebar { width: 250px; background: var(--primary); height: 100vh; color: white; position: fixed; padding-top: 20px; }
        .sidebar h2 { text-align: center; font-size: 22px; margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; }
        .sidebar a { display: block; color: white; padding: 15px 25px; text-decoration: none; transition: 0.3s; }
        .sidebar a:hover { background: var(--accent); padding-left: 35px; }
        .main-content { margin-left: 250px; flex: 1; padding: 40px; }
        .table-container { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 15px; border-bottom: 1px solid #eee; }
        .student-name { font-weight: 600; color: var(--primary); }
        .event-tag { background: #e8eaf6; color: var(--primary); padding: 4px 10px; border-radius: 5px; font-size: 13px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_dashboard.php">📊 Dashboard</a>
        <a href="manage_events.php">📅 Events</a>
        <a href="view_registrations.php" style="background: var(--accent);">👥 Registrations</a> 
        <a href="view_report_admin.php">📑 Reports</a>
        <a href="logout.php" style="margin-top: 50px; border-top: 1px solid rgba(255,255,255,0.1);">🚪 Logout</a>
    </div>

    <div class="main-content">
        <h1>Student Registrations</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Event Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="student-name"><?php echo htmlspecialchars($row['Student_Name']); ?></td>
                            <td><span class="event-tag"><?php echo htmlspecialchars($row['Event_Title']); ?></span></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="2" style="text-align: center; padding: 40px;">No registrations found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>