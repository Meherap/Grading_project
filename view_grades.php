
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grading_tool";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch students and their final grades
$sql = "SELECT students.student_name, grades.final_grade FROM students
        JOIN grades ON students.student_id = grades.student_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>Student Name</th><th>Final Grade</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["student_name"]. "</td><td>" . $row["final_grade"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No grades found";
}

$conn->close();
?>
