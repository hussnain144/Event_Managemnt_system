<?php
session_start();
// Check karein ke sirf Organizer hi access kare
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Organizer') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create VIP Event - VU System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a237e;
            --accent: #3949ab;
            --bg: #f0f2f5;
            --white: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            background: var(--white);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h2 {
            color: var(--primary);
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        .form-header p {
            color: #666;
            font-size: 14px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #444;
            font-weight: 500;
            font-size: 14px;
        }

        input, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e1e1;
            border-radius: 10px;
            font-family: inherit;
            font-size: 14px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input:focus, textarea:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 8px rgba(57, 73, 171, 0.1);
        }

        .grid-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            width: 100%;
            padding: 15px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            background: #0d124a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #666;
            text-decoration: none;
            font-size: 13px;
        }

        .back-link:hover { color: var(--primary); }
    </style>
</head>
<body>

    <div class="form-container">
        <div class="form-header">
            <h2>✨ Post New Event</h2>
            <p>Fill in the details to submit your event for Admin approval</p>
        </div>

        <form action="save_event.php" method="POST">
            <div class="input-group">
                <label>Event Title</label>
                <input type="text" name="title" placeholder="e.g. Annual Tech Symposium" required>
            </div>

            <div class="input-group">
                <label>Description</label>
                <textarea name="description" placeholder="Describe what this event is about..."></textarea>
            </div>

            <div class="grid-inputs">
                <div class="input-group">
                    <label>Event Date</label>
                    <input type="date" name="date" required>
                </div>
                <div class="input-group">
                    <label>Start Time</label>
                    <input type="time" name="time" required>
                </div>
            </div>

            <div class="grid-inputs">
                <div class="input-group">
                    <label>Venue Name</label>
                    <input type="text" name="venue" placeholder="e.g. Main Auditorium" required>
                </div>
                <div class="input-group">
                    <label>Max Capacity</label>
                    <input type="number" name="capacity" placeholder="e.g. 200" required>
                </div>
            </div>

            <button type="submit">🚀 Submit for Approval</button>
            <a href="organizer_dashboard.php" class="back-link">← Back to Dashboard</a>
        </form>
    </div>

</body>
</html>