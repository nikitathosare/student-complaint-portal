<?php
// RDS Database credentials
$servername = "your-rds-endpoint.amazonaws.com"; // Example: mydb.cle2abcd123.us-east-1.rds.amazonaws.com
$username   = "admin";   // your DB username
$password   = "yourpassword"; // your DB password
$dbname     = "mydb";    // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capture form data
$name = mysqli_real_escape_string($conn, $_POST['name']);
$student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
$enrollment_number = mysqli_real_escape_string($conn, $_POST['enrollment_number']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$department = mysqli_real_escape_string($conn, $_POST['department']);
$semester = mysqli_real_escape_string($conn, $_POST['semester']);
$recipients = isset($_POST['recipients']) ? implode(', ', $_POST['recipients']) : '';
$complaint_type = mysqli_real_escape_string($conn, $_POST['complaint_type']);
$subject = mysqli_real_escape_string($conn, $_POST['subject']);
$message = mysqli_real_escape_string($conn, $_POST['message']);
$priority = mysqli_real_escape_string($conn, $_POST['priority']);
$submission_date = date('Y-m-d H:i:s');

// Insert into database
$sql = "INSERT INTO student_complaints (
    name, 
    student_id, 
    enrollment_number, 
    email, 
    department, 
    semester, 
    recipients, 
    complaint_type, 
    subject, 
    message, 
    priority, 
    submission_date
) VALUES (
    '$name', 
    '$student_id', 
    '$enrollment_number', 
    '$email', 
    '$department', 
    '$semester', 
    '$recipients', 
    '$complaint_type', 
    '$subject', 
    '$message', 
    '$priority', 
    '$submission_date'
)";

if ($conn->query($sql) === TRUE) {
    // Redirect to success page with parameters
    $complaint_id = $conn->insert_id;
    header("Location: success.php?id=$complaint_id&recipients=" . urlencode($recipients));
    exit();
} else {
    echo "<div style='text-align: center; padding: 50px; color: #ff6b6b;'>";
    echo "<h2>Error submitting complaint</h2>";
    echo "<p>Error: " . $conn->error . "</p>";
    echo "<a href='javascript:history.back()' style='color: #00b4db;'>Go Back</a>";
    echo "</div>";
}

$conn->close();
?>