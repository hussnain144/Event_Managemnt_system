<?php
session_start();
include 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: index.php");
    exit();
}

// Tamam events fetch karna
$sql = "SELECT Events.*, Users.Name as OrganizerName FROM Events 
        JOIN Users ON Events.Organizer_ID = Users.User_ID 
        ORDER BY Date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage All Events - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7f6; margin: 0; display: flex; }
        .sidebar { width: 250px; background: #1a237e; color: white; height: 100vh; position: fixed; padding-top: 20px; }
        .sidebar a { display: block; color: white; padding: 15px 25px; text-decoration: none; }
        .main-content { flex: 1; margin-left: 250px; padding: 40px; }
        .table-container { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; }
        .status-Approved { background: #e8f5e9; color: #2e7d32; }
        .status-Pending { background: #fff3e0; color: #f57c00; }
        .btn-delete { color: #d32f2f; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin</h2>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="manage_events.php" style="background:#121858">Events</a>
        <a href="view_report_admin.php">Reports</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main-content">
        <h1>Manage All Events</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Organizer</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['Title']; ?></td>
                        <td><?php echo $row['OrganizerName']; ?></td>
                        <td><span class="badge status-<?php echo $row['Status']; ?>"><?php echo $row['Status']; ?></span></td>
                        <td>
                            <a href="view_event_details.php?id=<?php echo $row['Event_ID']; ?>">View</a> | 
                            <a href="delete_event.php?id=<?php echo $row['Event_ID']; ?>" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>