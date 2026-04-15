<?php
$conn = new mysqli('localhost','root','root','feedback_system');

$date = date('Y-m-d');

foreach($_POST['status'] as $email => $status){

    $stmt = $conn->prepare("INSERT INTO attendance(student_email, date, status) VALUES(?,?,?)");
    $stmt->bind_param("sss", $email, $date, $status);
    $stmt->execute();
    $stmt->close();
}

echo "Attendance Saved Successfully!";
echo "<br><a href='faculty_dashboard.php'>Go Back</a>";
?>