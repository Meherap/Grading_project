
<?php
// Database connection
$servername = "localhost";
$username = "root";  // Adjust accordingly
$password = "";      // Adjust accordingly
$dbname = "grading_tool";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $homework_1 = $_POST['homework_1'];
    $homework_2 = $_POST['homework_2'];
    $homework_3 = $_POST['homework_3'];
    $homework_4 = $_POST['homework_4'];
    $homework_5 = $_POST['homework_5'];
    $quiz_1 = $_POST['quiz_1'];
    $quiz_2 = $_POST['quiz_2'];
    $quiz_3 = $_POST['quiz_3'];
    $quiz_4 = $_POST['quiz_4'];
    $quiz_5 = $_POST['quiz_5'];
    $midterm = $_POST['midterm'];
    $final_project = $_POST['final_project'];

    // Calculate average homework grade
    $homework_avg = ($homework_1 + $homework_2 + $homework_3 + $homework_4 + $homework_5) / 5;

    // Drop the lowest quiz score and calculate quiz average
    $quizzes = array($quiz_1, $quiz_2, $quiz_3, $quiz_4, $quiz_5);
    sort($quizzes);
    array_shift($quizzes); // Remove the lowest quiz score
    $quiz_avg = array_sum($quizzes) / count($quizzes);

    // Calculate final grade
    $final_grade = ($homework_avg * 0.2) + ($quiz_avg * 0.1) + ($midterm * 0.3) + ($final_project * 0.4);
    $final_grade = round($final_grade); // Round to the nearest whole number

    // Insert grades into the database
    $sql = "INSERT INTO grades (student_id, homework_1, homework_2, homework_3, homework_4, homework_5, quiz_1, quiz_2, quiz_3, quiz_4, quiz_5, midterm, final_project, final_grade)
            VALUES ('$student_id', '$homework_1', '$homework_2', '$homework_3', '$homework_4', '$homework_5', '$quiz_1', '$quiz_2', '$quiz_3', '$quiz_4', '$quiz_5', '$midterm', '$final_project', '$final_grade')";

    if ($conn->query($sql) === TRUE) {
        echo "Grades successfully added! Final Grade: $final_grade";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!-- HTML Form to submit grades -->
<form method="post" action="">
    <label for="student_id">Student ID:</label>
    <input type="text" name="student_id" required><br>
    <label for="homework_1">Homework 1:</label>
    <input type="number" name="homework_1" required><br>
    <label for="homework_2">Homework 2:</label>
    <input type="number" name="homework_2" required><br>
    <label for="homework_3">Homework 3:</label>
    <input type="number" name="homework_3" required><br>
    <label for="homework_4">Homework 4:</label>
    <input type="number" name="homework_4" required><br>
    <label for="homework_5">Homework 5:</label>
    <input type="number" name="homework_5" required><br>
    <label for="quiz_1">Quiz 1:</label>
    <input type="number" name="quiz_1" required><br>
    <label for="quiz_2">Quiz 2:</label>
    <input type="number" name="quiz_2" required><br>
    <label for="quiz_3">Quiz 3:</label>
    <input type="number" name="quiz_3" required><br>
    <label for="quiz_4">Quiz 4:</label>
    <input type="number" name="quiz_4" required><br>
    <label for="quiz_5">Quiz 5:</label>
    <input type="number" name="quiz_5" required><br>
    <label for="midterm">Midterm:</label>
    <input type="number" name="midterm" required><br>
    <label for="final_project">Final Project:</label>
    <input type="number" name="final_project" required><br>
    <input type="submit" value="Submit Grades">
</form>
