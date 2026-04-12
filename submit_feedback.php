<?php
session_start();
include 'config.php';

$event_id = $_GET['id'];
$student_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Submit Feedback</title>
    <style>
        .feedback-box { width: 400px; margin: 50px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        select, textarea { width: 100%; padding: 10px; margin: 10px 0; }
        button { width: 100%; padding: 10px; background: #1a237e; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="feedback-box">
        <h3>Rate the Event</h3>
        <form action="save_feedback.php" method="POST">
            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
            <label>Rating (1-5):</label>
            <select name="rating" required>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Very Good</option>
                <option value="3">3 - Good</option>
                <option value="2">2 - Fair</option>
                <option value="1">1 - Poor</option>
            </select>
            <textarea name="comments" placeholder="Write your comments here..." required></textarea>
            <button type="submit">Submit Feedback</button>
        </form>
    </div>
</body>
</html>