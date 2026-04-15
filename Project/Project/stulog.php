<?php
// Start the session to store user info
session_start();

// Get POST data
$email = $_POST['email'];
$password = $_POST['password'];

// Database connection
$conn = new mysqli('localhost', 'root', 'root', 'feedback_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute query to get user info
$stmt = $conn->prepare("SELECT password, name FROM signupform WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashedPasswordFromDB, $nameFromDB);
    $stmt->fetch();

    // Verify the password
    if (password_verify($password, $hashedPasswordFromDB)) {
        // Password correct, set session
        $_SESSION['user'] = $nameFromDB;
        echo "Login successful! Welcome, " . $nameFromDB;
        // Redirect to dashboard or homepage
        // header("Location: dashboard.php");
        // exit();
    } else {
        echo "Invalid password!";
    }
} else {
    echo "No user found with this email!";
}

$stmt->close();
$conn->close();
?>