<?php
$complaint_id = isset($_GET['id']) ? $_GET['id'] : 'N/A';
$recipients = isset($_GET['recipients']) ? $_GET['recipients'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Submitted Successfully</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .success-container {
            max-width: 600px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 50px 40px;
            backdrop-filter: blur(10px);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            border-radius: 50%;
            margin: 0 auto 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: bounce 0.8s ease-out;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }

        .checkmark {
            color: white;
            font-size: 50px;
            font-weight: bold;
        }

        .success-title {
            color: #0083b0;
            font-size: 2.5em;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .success-message {
            color: #555;
            font-size: 1.2em;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .complaint-details {
            background: #f0fbff;
            padding: 25px;
            border-radius: 15px;
            margin: 30px 0;
            border-left: 5px solid #00b4db;
        }

        .detail-item {
            margin-bottom: 15px;
            text-align: left;
        }

        .detail-label {
            font-weight: 600;
            color: #0083b0;
            display: inline-block;
            min-width: 140px;
        }

        .detail-value {
            color: #333;
        }

        .recipients-list {
            background: white;
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
        }

        .recipient-tag {
            display: inline-block;
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            margin: 5px;
            font-size: 0.9em;
            font-weight: 500;
        }

        .action-buttons {
            margin-top: 40px;
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 50px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: white;
            box-shadow: 0 10px 25px rgba(0, 180, 219, 0.3);
        }

        .btn-secondary {
            background: white;
            color: #0083b0;
            border: 2px solid #00b4db;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 180, 219, 0.4);
        }

        @media (max-width: 768px) {
            .success-container {
                padding: 30px 25px;
            }
            
            .success-title {
                font-size: 2em;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <div class="checkmark">✓</div>
        </div>
        
        <h1 class="success-title">Complaint Submitted Successfully!</h1>
        
        <p class="success-message">
            Your complaint has been received and will be reviewed by the appropriate authorities. 
            You will receive updates on your registered email address.
        </p>

        <div class="complaint-details">
            <div class="detail-item">
                <span class="detail-label">Complaint ID:</span>
                <span class="detail-value">#<?php echo htmlspecialchars($complaint_id); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Submission Date:</span>
                <span class="detail-value"><?php echo date('F j, Y \a\t g:i A'); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Status:</span>
                <span class="detail-value">Under Review</span>
            </div>
            <?php if (!empty($recipients)): ?>
            <div class="detail-item">
                <span class="detail-label">Sent to:</span>
                <div class="recipients-list">
                    <?php
                    $recipient_array = explode(', ', $recipients);
                    foreach ($recipient_array as $recipient) {
                        echo "<span class='recipient-tag'>" . htmlspecialchars($recipient) . "</span>";
                    }
                    ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="action-buttons">
            <a href="index.html" class="btn btn-primary">Submit Another Complaint</a>
            <a href="view_complaints.php" class="btn btn-secondary">View All Complaints</a>
        </div>
    </div>
</body>
</html>