<?php
$fullName = $_POST['name'];
$branch = $_POST['branch'];
$year = $_POST['year'];
$semester = $_POST['semester'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Database connection
$conn = new mysqli('localhost','root','root','feedback_system');
if($conn->connect_error){
    die("Connection Failed : ". $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO signupform(name, branch, year, semester, email, password) VALUES(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $fullName, $branch, $year, $semester, $email, $hashedPassword);

    $execval = $stmt->execute();
    if ($execval) {
        echo "Signup successfully...";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();

echo "<br><a href='studentlog.html'>Click here to login</a>";
?>