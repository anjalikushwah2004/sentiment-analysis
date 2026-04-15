<?php
$conn = new mysqli('localhost','root','root','feedback_system');

// fetch students
$result = $conn->query("SELECT name, branch, year, semester, email FROM students");

echo "<h2>Faculty Dashboard - Mark Attendance</h2>";

echo "<form method='POST' action='save_attendance.php'>";

echo "<table border='1' cellpadding='10'>
<tr>
<th>Name</th>
<th>Branch</th>
<th>Year</th>
<th>Semester</th>
<th>Email</th>
<th>Status</th>
</tr>";

while($row = $result->fetch_assoc()){
    echo "<tr>
        <td>{$row['name']}</td>
        <td>{$row['branch']}</td>
        <td>{$row['year']}</td>
        <td>{$row['semester']}</td>
        <td>{$row['email']}</td>
        <td>
            <select name='status[{$row['email']}]'>
                <option value='Present'>Present</option>
                <option value='Absent'>Absent</option>
            </select>
        </td>
    </tr>";
}

echo "</table><br>";
echo "<input type='submit' value='Save Attendance'>";
echo "</form>";
?>