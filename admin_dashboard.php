<?php
session_start();
include 'config.php';

// 1. Authorization Check: Sirf Admin hi access kar sake
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: index.php");
    exit();
}

// 2. Stats Fetch karna (Real-time counts)
$pending_count = $conn->query("SELECT COUNT(*) as total FROM Events WHERE Status='Pending'")->fetch_assoc()['total'];
$approved_count = $conn->query("SELECT COUNT(*) as total FROM Events WHERE Status='Approved'")->fetch_assoc()['total'];
$report_count = 8; // Aap isay database se count kar sakte hain agar Reports table hai

// Real-time Registration Count
$reg_count = $conn->query("SELECT COUNT(*) as total FROM Registrations")->fetch_assoc()['total'];

// 3. Pending Events Fetch karna
$sql = "SELECT Events.*, Users.Name as OrganizerName FROM Events 
        JOIN Users ON Events.Organizer_ID = Users.User_ID 
        WHERE Status='Pending'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - VU Event System</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; display: flex; background: #f4f7f6; color: #333; }
        
        /* Sidebar styling */
        .sidebar { width: 250px; background: #1a237e; color: white; height: 100vh; position: fixed; padding-top: 20px; }
        .sidebar h2 { text-align: center; font-size: 22px; margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; }
        .sidebar a { display: block; color: white; padding: 15px 25px; text-decoration: none; transition: 0.3s; font-size: 15px; }
        .sidebar a:hover { background: #3949ab; padding-left: 35px; }
        
        .main-content { flex: 1; margin-left: 250px; padding: 40px; }
        
        /* Stats Cards styling */
        .stats-container { display: flex; gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 25px; border-radius: 12px; flex: 1; box-shadow: 0 4px 12px rgba(0,0,0,0.05); text-align: center; border-bottom: 4px solid #1a237e; }
        .stat-card h2 { margin: 0; color: #1a237e; font-size: 32px; }
        .stat-card p { margin: 5px 0 0; color: #666; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
        
        /* Table styling */
        .table-container { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { color: #888; font-weight: 500; font-size: 14px; }
        
        /* Buttons styling */
        .btn { padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: bold; transition: 0.2s; border: none; cursor: pointer; display: inline-block; }
        .btn-approve { background: #1a237e; color: white; margin-right: 5px; }
        .btn-approve:hover { background: #121858; transform: translateY(-1px); }
        .btn-reject { background: transparent; color: #d32f2f; border: 1px solid #d32f2f; }
        .btn-reject:hover { background: #ffebee; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_dashboard.php">📊 Dashboard</a>
        <a href="manage_events.php">📅 Events</a>
        <a href="view_registrations.php">👥 Registrations</a> <a href="view_report_admin.php">📑 Reports</a>
        <a href="logout.php" style="margin-top: 50px; border-top: 1px solid rgba(255,255,255,0.1);">🚪 Logout</a>
    </div>

    <div class="main-content">
        <h1 style="margin-bottom: 30px;">Admin Dashboard</h1>
        
        <div class="stats-container">
            <div class="stat-card">
                <h2><?php echo $pending_count; ?></h2>
                <p>Pending Approvals</p>
            </div>
            <div class="stat-card">
                <h2><?php echo $approved_count; ?></h2>
                <p>Upcoming Events</p>
            </div>
            <div class="stat-card">
                <h2><?php echo $report_count; ?></h2>
                <p>Reports</p>
            </div>
            <div class="stat-card" style="border-bottom-color: #2e7d32;">
                <h2><?php echo $reg_count; ?></h2>
                <p>New Registrations</p>
            </div>
        </div>

        <div class="table-container">
            <h3 style="margin-top: 0; margin-bottom: 20px; color: #1a237e;">Pending Approvals</h3>
            <table>
                <thead>
                    <tr>
                        <th>Event Title</th>
                        <th>Date</th>
                        <th>Organizer</th>
                        <th style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($row['Title']); ?></strong></td>
                            <td><?php echo date('M d, Y', strtotime($row['Date'])); ?></td>
                            <td><?php echo htmlspecialchars($row['OrganizerName']); ?></td>
                            <td style="text-align: center;">
                                <a href="update_status.php?id=<?php echo $row['Event_ID']; ?>&status=Approved" class="btn btn-approve">Approve</a>
                                <a href="update_status.php?id=<?php echo $row['Event_ID']; ?>&status=Rejected" class="btn btn-reject" onclick="return confirm('Reject this event?')">Reject</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: #999; padding: 40px;">No pending events for approval.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>