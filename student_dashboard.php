<?php
session_start();
include 'config.php';

// Authorization Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Student') {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'Student';

// Approved events fetch karna
$sql = "SELECT * FROM Events WHERE Status='Approved' AND Date >= CURDATE() ORDER BY Date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - VU Events</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #1a237e;
            --light-blue: #e8eaf6;
            --accent-color: #3949ab;
            --text-dark: #333;
            --bg-gray: #f4f7f9;
            --success-green: #2e7d32;
            --danger-red: #c62828;
        }

        body { font-family: 'Poppins', sans-serif; background-color: var(--bg-gray); margin: 0; color: var(--text-dark); }
        .header { background: linear-gradient(135deg, var(--primary-blue), var(--accent-color)); color: white; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 12px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 1000; }
        .logo { font-size: 20px; font-weight: 600; letter-spacing: 1px; }
        .user-profile { display: flex; align-items: center; gap: 15px; }
        .logout-btn { background: rgba(255,255,255,0.2); color: white; padding: 8px 18px; border-radius: 20px; text-decoration: none; font-size: 14px; transition: 0.3s; border: 1px solid rgba(255,255,255,0.3); }
        .logout-btn:hover { background: white; color: var(--primary-blue); }

        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .welcome-section { margin-bottom: 30px; }
        .welcome-section h1 { font-size: 28px; color: var(--primary-blue); margin: 0; }
        
        .event-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px; }
        .event-card { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.05); transition: transform 0.3s ease; display: flex; flex-direction: column; border: 1px solid #eee; }
        .event-card:hover { transform: translateY(-10px); }
        .card-header { background: var(--light-blue); padding: 20px; border-bottom: 1px solid #e0e0e0; }
        .card-header h3 { margin: 0; color: var(--primary-blue); font-size: 18px; }
        .card-body { padding: 20px; flex-grow: 1; }
        .info-row { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; font-size: 14px; color: #555; }
        .card-footer { padding: 20px; border-top: 1px solid #f5f5f5; }

        /* Button Styling */
        .btn-group { display: flex; gap: 10px; }
        .btn { display: block; text-align: center; padding: 10px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 13px; transition: 0.3s; flex: 1; }
        
        .btn-reg { background: var(--primary-blue); color: white; }
        .btn-reg:hover { background: var(--accent-color); }
        
        .btn-unbook { background: #fff5f5; color: var(--danger-red); border: 1px solid var(--danger-red); }
        .btn-unbook:hover { background: var(--danger-red); color: white; }
        
        .btn-feedback { background: var(--light-blue); color: var(--primary-blue); }
        .btn-feedback:hover { background: var(--primary-blue); color: white; }

        .badge { background: #4caf50; color: white; padding: 4px 10px; border-radius: 50px; font-size: 11px; text-transform: uppercase; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">VU EVENT SYSTEM</div>
        <div class="user-profile">
            <span>Welcome, <strong><?php echo htmlspecialchars($user_name); ?></strong></span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="welcome-section">
            <h1>Campus Events Explorer</h1>
            <p>Stay updated with the latest seminars, workshops, and competitions.</p>
        </div>

        <div class="event-grid">
            <?php if($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): 
                    $event_id = $row['Event_ID'];
                    $check_reg = $conn->query("SELECT * FROM Registrations WHERE Event_ID = $event_id AND Student_ID = $user_id");
                    $is_registered = ($check_reg->num_rows > 0);
                ?>
                <div class="event-card">
                    <div class="card-header">
                        <span class="badge">Open</span>
                        <h3><?php echo htmlspecialchars($row['Title']); ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="info-row">📅 <span><?php echo date('M d, Y', strtotime($row['Date'])); ?></span></div>
                        <div class="info-row">⏰ <span><?php echo date('h:i A', strtotime($row['Time'])); ?></span></div>
                        <div class="info-row">📍 <span><?php echo htmlspecialchars($row['Venue']); ?></span></div>
                        <p style="font-size: 13px; color: #777;"><?php echo htmlspecialchars(substr($row['Description'], 0, 100)); ?>...</p>
                    </div>
                    <div class="card-footer">
                        <?php if($is_registered): ?>
                            <div class="btn-group">
                                <a href="cancel_booking.php?id=<?php echo $event_id; ?>" 
                                   class="btn btn-unbook" 
                                   onclick="return confirm('Do you want to cancel your booking?')">Unbook</a>
                                
                                <a href="give_feedback.php?id=<?php echo $event_id; ?>" 
                                   class="btn btn-feedback">Feedback</a>
                            </div>
                        <?php else: ?>
                            <a href="register_event.php?id=<?php echo $event_id; ?>" class="btn btn-reg">Book My Seat</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 50px;">
                    <h3>No Upcoming Events Found</h3>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
<script>
// Browser notification permission mangna
if (Notification.permission !== "granted") {
    Notification.requestPermission();
}

function checkAutoReminders() {
    <?php
    // Logic: Wo events uthao jo 'Approved' hain aur 'Kal' (CURDATE + 1) hone wale hain
    // Aur check karo ke ye student usmein registered hai
    $auto_sql = "SELECT Title, Time FROM Events 
                 JOIN Registrations ON Events.Event_ID = Registrations.Event_ID 
                 WHERE Registrations.Student_ID = $user_id 
                 AND Events.Date = DATE_ADD(CURDATE(), INTERVAL 1 DAY)";
    
    $auto_res = $conn->query($auto_sql);
    
    while($row = $auto_res->fetch_assoc()):
        $t = $row['Title'];
        $time = date('h:i A', strtotime($row['Time']));
    ?>
    
    if (Notification.permission === "granted") {
        new Notification("📅 Upcoming Event Tomorrow!", {
            body: "Tayyar rahein! Kal aapka event '<?php echo $t; ?>' theek <?php echo $time; ?> baje shuru hoga.",
            icon: "https://cdn-icons-png.flaticon.com/512/3652/3652191.png"
        });
    }
    <?php endwhile; ?>
}

// Jab bhi student dashboard khole, check kare
window.onload = checkAutoReminders;
</script>
</html>