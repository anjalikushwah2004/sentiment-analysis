<?php
	$fullName = $_POST['name'];
	$facultyId = $_POST['facultyId'];
	$department = $_POST['department'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	

	// Database connection
	$conn = new mysqli('localhost','root','root','feedback_system');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		$stmt = $conn->prepare("insert into signupform(name, facultyId, department, email, password) values(?, ?, ?, ?, ?)");
		$stmt->bind_param("sssss", $fullName, $facultyId, $department, $email, $password );
		$execval = $stmt->execute();
		echo $execval;
		echo "Signup successfully...";
		$stmt->close();
    }
	echo "<br><a href='login.html'>click here to login</a>";
    $conn->close();
?>



