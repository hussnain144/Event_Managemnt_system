<?php
session_start();
include 'config.php';

// Authorization Check: Sirf Organizer hi access kar sake
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Organizer') {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'Organizer';

// 1. Stats Fetch karna
$total_events = $conn->query("SELECT COUNT(*) as total FROM Events WHERE Organizer_ID = $user_id")->fetch_assoc()['total'];
$approved_events = $conn->query("SELECT COUNT(*) as total FROM Events WHERE Organizer_ID = $user_id AND Status='Approved'")->fetch_assoc()['total'];
$pending_events = $conn->query("SELECT COUNT(*) as total FROM Events WHERE Organizer_ID = $user_id AND Status='Pending'")->fetch_assoc()['total'];

// 2. Events Fetch karna
$sql = "SELECT Events.*, 
        (SELECT COUNT(*) FROM Registrations WHERE Registrations.Event_ID = Events.Event_ID) as Total_Booked 
        FROM Events 
        WHERE Organizer_ID = $user_id 
        ORDER BY Date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Organizer Dashboard - VU Events</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a237e;
            --accent: #3949ab;
            --success: #2e7d32;
            --warning: #f57c00;
            --danger: #d32f2f;
            --bg: #f0f2f5;
        }

        body { font-family: 'Poppins', sans-serif; margin: 0; display: flex; background-color: var(--bg); }

        /* Sidebar Update */
        .sidebar { width: 260px; background: var(--primary); height: 100vh; color: white; position: fixed; padding-top: 20px; box-shadow: 4px 0 10px rgba(0,0,0,0.1); }
        .sidebar h2 { text-align: center; font-size: 20px; letter-spacing: 1px; margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; }
        .sidebar a { display: block; color: rgba(255,255,255,0.8); padding: 15px 25px; text-decoration: none; transition: 0.3s; font-size: 15px; }
        .sidebar a:hover { background: var(--accent); color: white; padding-left: 35px; }
        .sidebar .active { background: var(--accent); color: white; border-left: 5px solid white; }

        /* Main Content */
        .main-content { margin-left: 260px; flex: 1; padding: 40px; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        
        .btn-create { background: var(--success); color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: 600; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2); transition: 0.3s; }
        .btn-create:hover { transform: translateY(-2px); }

        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); text-align: center; border-left: 5px solid var(--primary); }
        .stat-card p { margin: 10px 0 0; font-size: 28px; font-weight: 600; color: var(--primary); }

        /* Table Styling */
        .table-container { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #888; border-bottom: 2px solid #eee; }
        td { padding: 15px; border-bottom: 1px solid #f9f9f9; font-size: 14px; }

        .badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-approved { background: #e8f5e9; color: var(--success); }
        .status-pending { background: #fff3e0; color: var(--warning); }
        
        .action-links a { text-decoration: none; font-weight: 600; font-size: 13px; margin-right: 15px; transition: 0.3s; }
        .edit-link { color: var(--accent); }
        .delete-link { color: var(--danger); }
    </style>
</head>
<body>

    <div class="sidebar">
    <h2>ORGANIZER</h2>
    <a href="organizer_dashboard.php">🏠 Dashboard</a>
    <a href="create_event.php">➕ Create Event</a>
    <a href="manage_participants.php">👥 Participants</a>
    <a href="view_feedbacks.php">⭐ Event Feedbacks</a>
    <a href="view_reports_org.php">📊 Event Reports</a> <a href="logout.php" style="margin-top: 50px; border-top: 1px solid rgba(255,255,255,0.1);">🚪 Logout</a>
</div>

    <div class="main-content">
        <div class="top-bar">
            <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
            <a href="create_event.php" class="btn-create">Create New Event</a>
        </div>

        <?php if(isset($_GET['msg'])): ?>
            <div id="alert-box" style="background: #e8f5e9; color: #2e7d32; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #2e7d32;">
                ✅ <?php echo htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card"><h3>Total Events</h3><p><?php echo $total_events; ?></p></div>
            <div class="stat-card" style="border-left-color: var(--success);"><h3>Approved</h3><p><?php echo $approved_events; ?></p></div>
            <div class="stat-card" style="border-left-color: var(--warning);"><h3>Pending</h3><p><?php echo $pending_events; ?></p></div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Event Title</th>
                        <th>Date</th>
                        <th>Bookings</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($row['Title']); ?></strong></td>
                            <td><?php echo date('M d, Y', strtotime($row['Date'])); ?></td>
                            <td><span style="color: var(--primary); font-weight: 500;"><?php echo $row['Total_Booked']; ?></span> Registered</td>
                            <td><span class="badge status-<?php echo strtolower($row['Status']); ?>"><?php echo $row['Status']; ?></span></td>
                            <td class="action-links">
                                <a href="edit_event.php?id=<?php echo $row['Event_ID']; ?>" class="edit-link">Edit</a>
                                <a href="delete_event.php?id=<?php echo $row['Event_ID']; ?>" class="delete-link" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align: center; color: #999; padding: 30px;">No events found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const alertBox = document.getElementById('alert-box');
            if(alertBox) alertBox.style.display = 'none';
        }, 3000);
    </script>

</body>
</html>