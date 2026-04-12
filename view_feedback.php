<?php
include 'config.php';
// Yahan Admin ya Organizer check lagayein

$event_id = $_GET['id'];
$sql = "SELECT Feedback.*, Users.Name FROM Feedback 
        JOIN Users ON Feedback.Student_ID = Users.User_ID 
        WHERE Event_ID = $event_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback Report</title>
    <style>
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Event Feedback & Ratings</h2>
    <table>
        <tr>
            <th>Student Name</th>
            <th>Rating</th>
            <th>Comments</th>
            <th>Date</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['Name']; ?></td>
            <td><?php echo $row['Rating']; ?> / 5</td>
            <td><?php echo $row['Comments']; ?></td>
            <td><?php echo $row['Feedback_Date']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>