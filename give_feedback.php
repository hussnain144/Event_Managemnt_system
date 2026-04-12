<?php
session_start();
include 'config.php';
$event_id = $_GET['id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Feedback</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f0f2f5; display: flex; justify-content: center; padding-top: 50px; }
        .feedback-box { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 400px; }
        h2 { color: #1a237e; text-align: center; }
        select, textarea { width: 100%; padding: 12px; margin: 15px 0; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn-submit { background: #1a237e; color: white; border: none; width: 100%; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: 600; }
    </style>
</head>
<body>
    <div class="feedback-box">
        <h2>Event Feedback</h2>
        <form action="save_feedback.php" method="POST">
            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
            
            <label>How was your experience?</label>
            <select name="rating" required>
                <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                <option value="4">⭐⭐⭐⭐ Good</option>
                <option value="3">⭐⭐⭐ Average</option>
                <option value="2">⭐⭐ Poor</option>
                <option value="1">⭐ Terrible</option>
            </select>

            <textarea name="comments" rows="4" placeholder="Write your thoughts here..." required></textarea>
            
            <button type="submit" class="btn-submit">Submit Feedback</button>
            <a href="student_dashboard.php" style="display:block; text-align:center; margin-top:15px; color:#666; text-decoration:none;">Go Back</a>
        </form>
    </div>
</body>
</html>