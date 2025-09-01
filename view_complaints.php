<?php
// RDS Database credentials
$servername = "your-rds-endpoint.amazonaws.com";
$username   = "admin";
$password   = "yourpassword";
$dbname     = "mydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all complaints
$sql = "SELECT * FROM student_complaints ORDER BY submission_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Complaints Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: white;
            text-align: center;
            padding: 30px 20px;
        }

        .header h1 {
            font-size: 2.2em;
            margin-bottom: 10px;
        }

        .dashboard-content {
            padding: 40px;
        }

        .stats-row {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .stat-card {
            flex: 1;
            background: linear-gradient(135deg, #f0fbff 0%, #e6f9ff 100%);
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            border: 2px solid #e0f7ff;
            min-width: 200px;
        }

        .stat-number {
            font-size: 2.5em;
            font-weight: bold;
            color: #0083b0;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #555;
            font-weight: 600;
        }

        .complaints-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        tr:hover {
            background: #f8feff;
        }

        .priority-high {
            background: #ffe6e6;
            color: #cc0000;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
            font-weight: bold;
        }

        .priority-urgent {
            background: #ff3333;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
            font-weight: bold;
        }

        .priority-medium {
            background: #fff3cd;
            color: #856404;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
            font-weight: bold;
        }

        .priority-low {
            background: #d1ecf1;
            color: #0c5460;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
            font-weight: bold;
        }

        .status-badge {
            background: #00b4db;
            color: white;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.9em;
            font-weight: 500;
        }

        .recipients-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .recipient-tag {
            background: #e6f9ff;
            color: #0083b0;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 0.8em;
            font-weight: 500;
        }

        .back-btn {
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 50px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 30px;
        }

        .back-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 180, 219, 0.4);
        }

        .no-complaints {
            text-align: center;
            padding: 50px;
            color: #666;
        }

        @media (max-width: 768px) {
            .stats-row {
                flex-direction: column;
            }
            
            .dashboard-content {
                padding: 25px;
            }
            
            table {
                font-size: 0.9em;
            }
            
            th, td {
                padding: 10px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Student Complaints Dashboard</h1>
            <p>Manage and review all student complaints</p>
        </div>

        <div class="dashboard-content">
            <a href="index.html" class="back-btn">← Back to Form</a>

            <?php
            // Calculate statistics
            $total_complaints = $result->num_rows;
            
            $urgent_sql = "SELECT COUNT(*) as count FROM student_complaints WHERE priority = 'Urgent'";
            $urgent_result = $conn->query($urgent_sql);
            $urgent_count = $urgent_result->fetch_assoc()['count'];
            
            $pending_sql = "SELECT COUNT(*) as count FROM student_complaints WHERE status = 'Under Review'";
            $pending_result = $conn->query($pending_sql);
            $pending_count = $pending_result->fetch_assoc()['count'];
            ?>

            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $total_complaints; ?></div>
                    <div class="stat-label">Total Complaints</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $pending_count; ?></div>
                    <div class="stat-label">Pending Review</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $urgent_count; ?></div>
                    <div class="stat-label">Urgent Priority</div>
                </div>
            </div>

            <div class="complaints-table">
                <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student Info</th>
                            <th>Subject</th>
                            <th>Recipients</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($row['id']); ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($row['name']); ?></strong><br>
                                <small>ID: <?php echo htmlspecialchars($row['student_id']); ?></small><br>
                                <small><?php echo htmlspecialchars($row['email']); ?></small>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($row['subject']); ?></strong><br>
                                <small><?php echo htmlspecialchars($row['complaint_type']); ?></small>
                            </td>
                            <td>
                                <div class="recipients-tags">
                                    <?php
                                    if (!empty($row['recipients'])) {
                                        $recipients = explode(', ', $row['recipients']);
                                        foreach ($recipients as $recipient) {
                                            echo "<span class='recipient-tag'>" . htmlspecialchars($recipient) . "</span>";
                                        }
                                    }
                                    ?>
                                </div>
                            </td>
                            <td>
                                <span class="priority-<?php echo strtolower($row['priority']); ?>">
                                    <?php echo htmlspecialchars($row['priority']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="status-badge">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('M j, Y', strtotime($row['submission_date'])); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="no-complaints">
                    <h3>No complaints submitted yet</h3>
                    <p>When students submit complaints, they will appear here.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>