<?php
session_start();
include 'config.php';

// Authorization Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Organizer') {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Query: JOIN use kar ke data nikalna
// Note: $user_id ko hamesha quotes mein rakhein ya properly handle karein
$sql = "SELECT Feedback.*, Events.Title as Event_Title, Users.Name as Student_Name 
        FROM Feedback 
        JOIN Events ON Feedback.Event_ID = Events.Event_ID 
        JOIN Users ON Feedback.Student_ID = Users.User_ID 
        WHERE Events.Organizer_ID = '$user_id' 
        ORDER BY Feedback.Feedback_ID DESC";

$result = $conn->query($sql);

// Agar query fail ho jaye to error dikhaye (Sirf developer ke liye)
if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Feedbacks - Organizer</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a237e;
            --accent: #3949ab;
            --bg: #f0f2f5;
            --star: #fbc02d;
        }

        body { font-family: 'Poppins', sans-serif; margin: 0; display: flex; background-color: var(--bg); }

        /* Sidebar */
        .sidebar { width: 260px; background: var(--primary); height: 100vh; color: white; position: fixed; padding-top: 20px; box-shadow: 4px 0 10px rgba(0,0,0,0.1); }
        .sidebar h2 { text-align: center; font-size: 20px; letter-spacing: 1px; margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; }
        .sidebar a { display: block; color: rgba(255,255,255,0.8); padding: 15px 25px; text-decoration: none; transition: 0.3s; font-size: 15px; }
        .sidebar a:hover { background: var(--accent); color: white; padding-left: 35px; }
        .active { background: var(--accent); color: white; border-left: 5px solid white; }

        /* Main Content */
        .main-content { margin-left: 260px; flex: 1; padding: 40px; }
        h1 { color: var(--primary); margin-bottom: 10px; font-weight: 600; }
        .debug-info { color: #666; font-size: 13px; margin-bottom: 30px; }

        /* Feedback Card Styling */
        .feedback-card { 
            background: white; 
            padding: 25px; 
            border-radius: 15px; 
            margin-bottom: 20px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); 
            border-left: 6px solid var(--accent);
            transition: 0.3s;
        }
        .feedback-card:hover { transform: translateY(-5px); }

        .event-tag { 
            font-size: 12px; 
            background: #e8eaf6; 
            color: var(--primary); 
            padding: 5px 12px; 
            border-radius: 20px; 
            font-weight: 600; 
            display: inline-block; 
            margin-bottom: 10px; 
        }

        .student-name { font-size: 16px; font-weight: 600; color: #333; display: block; margin-bottom: 5px; }
        .stars { color: var(--star); font-size: 20px; margin-bottom: 10px; }
        
        .comment-box { 
            background: #f9f9f9; 
            padding: 15px; 
            border-radius: 10px; 
            color: #555; 
            font-style: italic; 
            border: 1px solid #eee;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>ORGANIZER</h2>
        <a href="organizer_dashboard.php">🏠 Dashboard</a>
        <a href="create_event.php">➕ Create Event</a>
        <a href="manage_participants.php">👥 Participants</a>
        <a href="view_feedbacks.php" class="active">⭐ Event Feedbacks</a>
        <a href="logout.php" style="margin-top: 100px; border-top: 1px solid rgba(255,255,255,0.1);">🚪 Logout</a>
    </div>

    <div class="main-content">
        <h1>Student Feedbacks</h1>
        <p class="debug-info">Logged-in ID: <?php echo $user_id; ?> | Found: <?php echo $result->num_rows; ?></p>

        <?php if($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="feedback-card">
                    <span class="event-tag">📍 <?php echo htmlspecialchars($row['Event_Title']); ?></span>
                    <span class="student-name">👤 <?php echo htmlspecialchars($row['Student_Name']); ?></span>
                    
                    <div class="stars">
                        <?php 
                        $rating = $row['Rating'];
                        for($i=1; $i<=5; $i++) {
                            echo ($i <= $rating) ? "★" : "☆";
                        }
                        ?>
                    </div>

                    <div class="comment-box">
                        "<?php echo htmlspecialchars($row['Comments']); ?>"
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

</body>
</html>