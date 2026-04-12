<?php
session_start();
include 'config.php';

// Authorization Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Organizer') {
    header("Location: index.php");
    exit();
}

$organizer_id = $_SESSION['user_id'];

// Query: Organizer ke events mein jin students ne register kiya unka data nikalna
$sql = "SELECT Registrations.Reg_ID, Users.Name as StudentName, Users.Email, Events.Title as EventTitle, Registrations.Reg_Date 
        FROM Registrations 
        JOIN Users ON Registrations.Student_ID = Users.User_ID 
        JOIN Events ON Registrations.Event_ID = Events.Event_ID 
        WHERE Events.Organizer_ID = $organizer_id 
        ORDER BY Registrations.Reg_Date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Participants - VU Events</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7f6; margin: 0; display: flex; }
        .sidebar { width: 260px; background: #1a237e; color: white; height: 100vh; position: fixed; padding-top: 20px; }
        .sidebar h2 { text-align: center; font-size: 20px; margin-bottom: 30px; }
        .sidebar a { display: block; color: rgba(255,255,255,0.8); padding: 15px 25px; text-decoration: none; }
        .sidebar a:hover { background: #3949ab; color: white; }
        
        .main-content { margin-left: 260px; flex: 1; padding: 40px; }
        .table-container { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; color: #888; font-size: 14px; }
        .badge-reg { background: #e8eaf6; color: #1a237e; padding: 5px 10px; border-radius: 5px; font-size: 12px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>ORGANIZER</h2>
        <a href="organizer_dashboard.php">🏠 Dashboard</a>
        <a href="create_event.php">➕ Create Event</a>
        <a href="manage_participants.php" style="background: #3949ab;">👥 Participants</a>
        <a href="logout.php" style="margin-top: 50px;">🚪 Logout</a>
    </div>

    <div class="main-content">
        <h1>Event Participants</h1>
        <p>List of students registered for your events.</p>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Event Title</th>
                        <th>Reg. Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td style="font-weight: 500;"><?php echo htmlspecialchars($row['StudentName']); ?></td>
                            <td><?php echo htmlspecialchars($row['Email']); ?></td>
                            <td><span class="badge-reg"><?php echo htmlspecialchars($row['EventTitle']); ?></span></td>
                            <td><?php echo date('M d, Y', strtotime($row['Reg_Date'])); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4" style="text-align: center; color: #999; padding: 40px;">No registrations found for your events.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>