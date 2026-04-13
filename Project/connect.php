<?php
// Database connection
	$servername = "localhost";
    $username   = "root";   // default for XAMPP
    $password   = "root";       // default empty
    $dbname     = "feedback_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Collect form data
    $department             = $_POST['department'] ?? '';
    $semester               = $_POST['semester'] ?? '';
    $student_id             = $_POST['student_id'] ?? '';
    $placement_training     = $_POST['placement_training'] ?? '';
    $placement_opportunities= $_POST['placement_opportunities'] ?? '';
    $placement_suggestions  = $_POST['placement_suggestions'] ?? '';
    $curriculum_usefulness  = $_POST['curriculum_usefulness'] ?? '';
    $extra_activities       = $_POST['extra_activities'] ?? '';
    $curriculum_suggestions = $_POST['curriculum_suggestions'] ?? '';

// ✅ Insert general feedback
$sql = "INSERT INTO feedback (
    department, semester, student_id, 
    placement_training, placement_opportunities, placement_suggestions, 
    curriculum_usefulness, extra_activities, curriculum_suggestions
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sisssssss", 
    $department, $semester, $student_id,
    $placement_training, $placement_opportunities, $placement_suggestions,
    $curriculum_usefulness, $extra_activities, $curriculum_suggestions
);

if ($stmt->execute()) {
    echo "<h2>✅ General feedback saved successfully!</h2>";
} else {
    echo "❌ Error (general feedback): " . $stmt->error;
}
$stmt->close();

// ✅ Insert teacher feedback
foreach ($_POST as $key => $value) {
    // Match inputs like "Mr.Ankit Bakshi_teaching"
    if (preg_match('/^(.*)_(teaching|communication|knowledge)$/', $key, $matches)) {
        $teacher = $matches[1]; // teacher name
        $field   = $matches[2]; // teaching / communication / knowledge

        // Prepare teacher data grouped by teacher
        $teacher_feedback[$teacher][$field] = $value;
    }
}

if (!empty($teacher_feedback)) {
    $sql_teacher = "INSERT INTO teacher_feedback (
        student_id, department, teacher_name, 
        teaching_quality, communication_skills, subject_knowledge
    ) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt_teacher = $conn->prepare($sql_teacher);

    foreach ($teacher_feedback as $teacher => $fb) {
        $teaching     = $fb['teaching'] ?? '';
        $communication= $fb['communication'] ?? '';
        $knowledge    = $fb['knowledge'] ?? '';

        $stmt_teacher->bind_param("ssssss", 
            $student_id, $department, $teacher, 
            $teaching, $communication, $knowledge
        );
        $stmt_teacher->execute();
    }
    $stmt_teacher->close();

    echo "<h2>✅ Teacher feedback saved successfully!</h2>";
}

$conn->close();

// Redirect or show Thank You page
echo "<br><a href='welcome.html'>Go to Home page</a>";

?>
